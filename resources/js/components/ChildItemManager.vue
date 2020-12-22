<template>
    <div class="w-full flex flex-col">
        <div v-if="loading" v-html="spinnerSrc"></div>
        <template v-else>
            <div class="text-xl font-bold w-full py-4"
                 v-html="title"></div>
            <div class="w-full flex flex-row">
                <div class="w-1/2 flex flex-col">
                    <div draggable="true"
                         v-for="item in items"
                         :data-itemid="item.id"
                         v-on:dragover="$event.preventDefault()"
                         v-on:dragstart="startMoving"
                         v-on:dragend="endMoving"
                         v-on:dragenter="showDragOverEffect($event, item.id)"
                         v-on:dragleave="hideDragOverEffect($event, item.id)"
                         v-on:drop="moveToBefore($event, item.id)"
                         :ref="'item-'+item.id"
                         class="flex">
                        <span v-html="item.label"></span>
                        <div class="absolute ml-4 right-0 top-0"
                             v-on:click="removeItem(item.id)"
                             v-show="moving === false"
                        >-
                        </div>
                    </div>
                    <div v-show="moving !== false"
                         class="child-item-drop-field"
                         :ref="'item-end'"
                         v-on:dragover="$event.preventDefault()"
                         v-on:dragenter="showDragOverEffect($event, 'end')"
                         v-on:dragleave="hideDragOverEffect($event, 'end')"
                         v-on:drop="moveToEnd($event)"
                    ><span></span></div>
                </div>

            </div>
        </template>
    </div>
</template>

<script>
    export default {
        props: {
            operationsUrl: {type: String},
            title: {type: String}
        },
        data: function () {
            return {
                loading: true,
                items: [],
                moving: false,
            }
        },
        mounted() {
        },
        methods: {
            showDragOverEffect: function(event, itemId) {
                event.preventDefault();
                let target = this.$refs['item-'+itemId][0] || this.$refs['item-'+itemId];
                if (target.getAttribute('data-itemid') !== this.moving) {
                    target.classList.add('child-item-dropping');
                }
            },
            hideDragOverEffect: function(event, itemId) {
                event.preventDefault();
                let target = this.$refs['item-'+itemId][0] || this.$refs['item-'+itemId];
                target.classList.remove('child-item-dropping');
            },
            removeItem: function (itemId) {
                this.items = this.items.filter(item => item.custom_id != itemId);
                this.emitValue();
            },
            startMoving: function(event) {
                let target = event.target;
                while (target.getAttribute('data-itemid') == null) {
                    target = target.parentNode;
                }
                event.dataTransfer.setData('id', target.getAttribute('data-itemid'));
                event.dataTransfer.setDragImage(target.querySelector('span'), 100, 100);
                window.setTimeout(() => {
                    Array.from(document.querySelectorAll('.child-item span')).forEach((t) => {
                        t.classList.add('pointer-events-none');
                    });
                    this.moving = target.getAttribute('data-itemid');
                    target.classList.add('child-item-hidden');
                }, 10);

            },
            endMoving: function(event) {
                event.target.classList.remove('child-item-hidden');
                this.moving = false;
                Array.from(document.querySelectorAll('.child-item')).forEach((t) => {
                    t.querySelector('span').classList.remove('pointer-events-none');
                    t.classList.remove('child-item-dropping');
                    t.classList.remove('child-item-hidden');
                });
                document.querySelector('.related-printers-drop-field').classList.remove('child-item-dropping');
            },
            moveToBefore: function(event, itemId) {
                event.stopPropagation();
                event.preventDefault();
                let newOrder = [];
                this.items.forEach((item) => {
                    if (item.custom_id == itemId) {
                        newOrder.push(this.items.find(element => element.custom_id == event.dataTransfer.getData('id')));
                    }
                    if (item.custom_id != event.dataTransfer.getData('id')) {
                        newOrder.push(item);
                    }
                });
                this.items = newOrder;
                this.emitValue();
            },
            moveToEnd: function(event) {
                event.stopPropagation();
                event.preventDefault();
                let item = this.items.find(element => element.custom_id == event.dataTransfer.getData('id'));
                this.removeItem(event.dataTransfer.getData('id'));
                this.items.push(item);
                this.emitValue();
            },

        },
        computed: {},
        watch: {}

    }
</script>
<style>
    .child-item-dropping {
        padding-top: 2rem !important;
    }
    .child-item-hidden {
        opacity: .25;
    }
    child-item-drop-field {
        height: 2rem;
        margin: .2rem;
        width: 100%;
        flex-shrink: 0;
        background-color: transparent;
        transition: transform 200ms ease-in-out, background-color 200ms ease-in-out;
    }
    .pointer-events-none {
        pointer-events: none;
    }

</style>