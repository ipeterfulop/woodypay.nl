<template>
    <div class="w-full flex flex-col items-stretch justify-start">
        <div v-if="loading" class="w-full flex p-4 items-center justify-center" v-html="spinnerSrc"></div>
        <template v-else>
            <div class="w-full flex flex-row space-between flex-wrap">
                <template v-if="filters.length > 0">
                    <div class="flex items-start justify-start flex-col"
                         v-for="filter in filters"
                         :class="filter['class']"
                    >
                        <label class="font-bold" v-html="filter['label']"></label>
                        <template v-if="filter['type'] == 'text'">
                            <div class="relative flex items-center">
                                <input type="text" v-model="filter['value']">
                                <button v-on:click="filter['value'] = ''"
                                        v-if="filter['value'] != ''"
                                        class="absolute bg-transparent right-0 mr-4">X</button>
                            </div>
                        </template>
                        <div v-if="filter['type'] == 'daterange'"
                            class="flex flex-row justify-between items-center">
                            <input type="date" v-model="filter['value'][0]">
                            <span class="mx-2">-</span>
                            <input type="date" v-model="filter['value'][1]">
                        </div>
                    </div>
                    <div class="w-full flex items-start justify-start py-4">
                        <button class="bg-blue-400 py-2 px-3 text-white"
                                v-on:click="fetchDataFromFilterButtonPress">Szűrés</button>
                    </div>
                </template>
            </div>
            <div class="min-w-full flex items-center justify-start my-2" v-if="!tableLoading && showPagination">
                Találatok száma: {{ total }}
            </div>
            <div class="min-w-full flex items-center justify-start my-2" v-if="!tableLoading && showPagination">
                <button v-on:click="gotoFirstPage" class="text-sm font-bold hover:border hover:border-gray-200 p-2  mx-1" v-bind:disabled="page == 1">&lt;&lt;</button>
                <button v-on:click="gotoPreviousPage" class="text-sm font-bold hover:border hover:border-gray-200 p-2  mx-1" v-bind:disabled="page == 1">&lt;</button>
                <select v-model="page">
                    <option v-for="p in pages" v-html="p" :value="p"></option>
                </select>
                <button v-on:click="gotoNextPage" class="text-sm font-bold hover:border hover:border-gray-200 p-2  mx-1" v-bind:disabled="page == pages.length">&gt;</button>
                <button v-on:click="gotoLastPage" class="text-sm font-bold hover:border hover:border-gray-200 p-2  mx-1" v-bind:disabled="page == pages.length">&gt;&gt;</button>
                <select v-model="itemsPerPage" class="ml-auto">
                    <option v-for="i in itemsPerPageOptions" v-html="i" :value="i"></option>
                </select>
                <label class="ml-2">elem / oldal</label>
            </div>
            <table :class="tableClass">
                <template v-if="tableLoading">
                    <tr><td v-html="spinnerSrc"></td></tr>
                </template>
                <template v-else>
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="thClass" v-for="columnData in columns" v-html="columnData.label">
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="row, index in data"
                            :class="index % 2 == 0 ? trOddClass : trEvenClass"
                        >
                            <td v-for="columnData in columns"
                                :class="combinedTdclass(columnData.field)"
                                v-html="row[columnData.field]"></td>

                        </tr>
                    </tbody>
                </template>
            </table>
        </template>
    </div>
</template>

<script>
    export default {
        props: {
            operationsUrl: {type: String},
            tableClass: {type: String, default: 'min-w-full divide-y divide-gray-200'},
            thclass: {type: String, default: 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'},
            trOddClass: {type: String, default: 'bg-white'},
            trEvenClass: {type: String, default: 'bg-gray-50'},
            tdClass: {type: String, default: 'px-6 py-4 whitespace-nowrap text-sm text-gray-500'},
            showPagination: {type: Boolean, default: true}
        },
        data: function () {
            return {
                loading: true,
                tableLoading: true,
                spinnerSrc: '<img style="max-height: 1em" alt="" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBzdGFuZGFsb25lPSJubyI/Pgo8IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4iICJodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQiPgo8c3ZnIHdpZHRoPSI0MHB4IiBoZWlnaHQ9IjQwcHgiIHZpZXdCb3g9IjAgMCA0MCA0MCIgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4bWw6c3BhY2U9InByZXNlcnZlIiBzdHlsZT0iZmlsbC1ydWxlOmV2ZW5vZGQ7Y2xpcC1ydWxlOmV2ZW5vZGQ7c3Ryb2tlLWxpbmVqb2luOnJvdW5kO3N0cm9rZS1taXRlcmxpbWl0OjEuNDE0MjE7IiB4PSIwcHgiIHk9IjBweCI+CiAgICA8ZGVmcz4KICAgICAgICA8c3R5bGUgdHlwZT0idGV4dC9jc3MiPjwhW0NEQVRBWwogICAgICAgICAgICBALXdlYmtpdC1rZXlmcmFtZXMgc3BpbiB7CiAgICAgICAgICAgICAgZnJvbSB7CiAgICAgICAgICAgICAgICAtd2Via2l0LXRyYW5zZm9ybTogcm90YXRlKDBkZWcpCiAgICAgICAgICAgICAgfQogICAgICAgICAgICAgIHRvIHsKICAgICAgICAgICAgICAgIC13ZWJraXQtdHJhbnNmb3JtOiByb3RhdGUoLTM1OWRlZykKICAgICAgICAgICAgICB9CiAgICAgICAgICAgIH0KICAgICAgICAgICAgQGtleWZyYW1lcyBzcGluIHsKICAgICAgICAgICAgICBmcm9tIHsKICAgICAgICAgICAgICAgIHRyYW5zZm9ybTogcm90YXRlKDBkZWcpCiAgICAgICAgICAgICAgfQogICAgICAgICAgICAgIHRvIHsKICAgICAgICAgICAgICAgIHRyYW5zZm9ybTogcm90YXRlKC0zNTlkZWcpCiAgICAgICAgICAgICAgfQogICAgICAgICAgICB9CiAgICAgICAgICAgIHN2ZyB7CiAgICAgICAgICAgICAgICAtd2Via2l0LXRyYW5zZm9ybS1vcmlnaW46IDUwJSA1MCU7CiAgICAgICAgICAgICAgICAtd2Via2l0LWFuaW1hdGlvbjogc3BpbiAxLjVzIGxpbmVhciBpbmZpbml0ZTsKICAgICAgICAgICAgICAgIC13ZWJraXQtYmFja2ZhY2UtdmlzaWJpbGl0eTogaGlkZGVuOwogICAgICAgICAgICAgICAgYW5pbWF0aW9uOiBzcGluIDEuNXMgbGluZWFyIGluZmluaXRlOwogICAgICAgICAgICB9CiAgICAgICAgXV0+PC9zdHlsZT4KICAgIDwvZGVmcz4KICAgIDxnIGlkPSJvdXRlciI+CiAgICAgICAgPGc+CiAgICAgICAgICAgIDxwYXRoIGQ9Ik0yMCwwQzIyLjIwNTgsMCAyMy45OTM5LDEuNzg4MTMgMjMuOTkzOSwzLjk5MzlDMjMuOTkzOSw2LjE5OTY4IDIyLjIwNTgsNy45ODc4MSAyMCw3Ljk4NzgxQzE3Ljc5NDIsNy45ODc4MSAxNi4wMDYxLDYuMTk5NjggMTYuMDA2MSwzLjk5MzlDMTYuMDA2MSwxLjc4ODEzIDE3Ljc5NDIsMCAyMCwwWiIgc3R5bGU9ImZpbGw6YmxhY2s7Ii8+CiAgICAgICAgPC9nPgogICAgICAgIDxnPgogICAgICAgICAgICA8cGF0aCBkPSJNNS44NTc4Niw1Ljg1Nzg2QzcuNDE3NTgsNC4yOTgxNSA5Ljk0NjM4LDQuMjk4MTUgMTEuNTA2MSw1Ljg1Nzg2QzEzLjA2NTgsNy40MTc1OCAxMy4wNjU4LDkuOTQ2MzggMTEuNTA2MSwxMS41MDYxQzkuOTQ2MzgsMTMuMDY1OCA3LjQxNzU4LDEzLjA2NTggNS44NTc4NiwxMS41MDYxQzQuMjk4MTUsOS45NDYzOCA0LjI5ODE1LDcuNDE3NTggNS44NTc4Niw1Ljg1Nzg2WiIgc3R5bGU9ImZpbGw6cmdiKDIxMCwyMTAsMjEwKTsiLz4KICAgICAgICA8L2c+CiAgICAgICAgPGc+CiAgICAgICAgICAgIDxwYXRoIGQ9Ik0yMCwzMi4wMTIyQzIyLjIwNTgsMzIuMDEyMiAyMy45OTM5LDMzLjgwMDMgMjMuOTkzOSwzNi4wMDYxQzIzLjk5MzksMzguMjExOSAyMi4yMDU4LDQwIDIwLDQwQzE3Ljc5NDIsNDAgMTYuMDA2MSwzOC4yMTE5IDE2LjAwNjEsMzYuMDA2MUMxNi4wMDYxLDMzLjgwMDMgMTcuNzk0MiwzMi4wMTIyIDIwLDMyLjAxMjJaIiBzdHlsZT0iZmlsbDpyZ2IoMTMwLDEzMCwxMzApOyIvPgogICAgICAgIDwvZz4KICAgICAgICA8Zz4KICAgICAgICAgICAgPHBhdGggZD0iTTI4LjQ5MzksMjguNDkzOUMzMC4wNTM2LDI2LjkzNDIgMzIuNTgyNCwyNi45MzQyIDM0LjE0MjEsMjguNDkzOUMzNS43MDE5LDMwLjA1MzYgMzUuNzAxOSwzMi41ODI0IDM0LjE0MjEsMzQuMTQyMUMzMi41ODI0LDM1LjcwMTkgMzAuMDUzNiwzNS43MDE5IDI4LjQ5MzksMzQuMTQyMUMyNi45MzQyLDMyLjU4MjQgMjYuOTM0MiwzMC4wNTM2IDI4LjQ5MzksMjguNDkzOVoiIHN0eWxlPSJmaWxsOnJnYigxMDEsMTAxLDEwMSk7Ii8+CiAgICAgICAgPC9nPgogICAgICAgIDxnPgogICAgICAgICAgICA8cGF0aCBkPSJNMy45OTM5LDE2LjAwNjFDNi4xOTk2OCwxNi4wMDYxIDcuOTg3ODEsMTcuNzk0MiA3Ljk4NzgxLDIwQzcuOTg3ODEsMjIuMjA1OCA2LjE5OTY4LDIzLjk5MzkgMy45OTM5LDIzLjk5MzlDMS43ODgxMywyMy45OTM5IDAsMjIuMjA1OCAwLDIwQzAsMTcuNzk0MiAxLjc4ODEzLDE2LjAwNjEgMy45OTM5LDE2LjAwNjFaIiBzdHlsZT0iZmlsbDpyZ2IoMTg3LDE4NywxODcpOyIvPgogICAgICAgIDwvZz4KICAgICAgICA8Zz4KICAgICAgICAgICAgPHBhdGggZD0iTTUuODU3ODYsMjguNDkzOUM3LjQxNzU4LDI2LjkzNDIgOS45NDYzOCwyNi45MzQyIDExLjUwNjEsMjguNDkzOUMxMy4wNjU4LDMwLjA1MzYgMTMuMDY1OCwzMi41ODI0IDExLjUwNjEsMzQuMTQyMUM5Ljk0NjM4LDM1LjcwMTkgNy40MTc1OCwzNS43MDE5IDUuODU3ODYsMzQuMTQyMUM0LjI5ODE1LDMyLjU4MjQgNC4yOTgxNSwzMC4wNTM2IDUuODU3ODYsMjguNDkzOVoiIHN0eWxlPSJmaWxsOnJnYigxNjQsMTY0LDE2NCk7Ii8+CiAgICAgICAgPC9nPgogICAgICAgIDxnPgogICAgICAgICAgICA8cGF0aCBkPSJNMzYuMDA2MSwxNi4wMDYxQzM4LjIxMTksMTYuMDA2MSA0MCwxNy43OTQyIDQwLDIwQzQwLDIyLjIwNTggMzguMjExOSwyMy45OTM5IDM2LjAwNjEsMjMuOTkzOUMzMy44MDAzLDIzLjk5MzkgMzIuMDEyMiwyMi4yMDU4IDMyLjAxMjIsMjBDMzIuMDEyMiwxNy43OTQyIDMzLjgwMDMsMTYuMDA2MSAzNi4wMDYxLDE2LjAwNjFaIiBzdHlsZT0iZmlsbDpyZ2IoNzQsNzQsNzQpOyIvPgogICAgICAgIDwvZz4KICAgICAgICA8Zz4KICAgICAgICAgICAgPHBhdGggZD0iTTI4LjQ5MzksNS44NTc4NkMzMC4wNTM2LDQuMjk4MTUgMzIuNTgyNCw0LjI5ODE1IDM0LjE0MjEsNS44NTc4NkMzNS43MDE5LDcuNDE3NTggMzUuNzAxOSw5Ljk0NjM4IDM0LjE0MjEsMTEuNTA2MUMzMi41ODI0LDEzLjA2NTggMzAuMDUzNiwxMy4wNjU4IDI4LjQ5MzksMTEuNTA2MUMyNi45MzQyLDkuOTQ2MzggMjYuOTM0Miw3LjQxNzU4IDI4LjQ5MzksNS44NTc4NloiIHN0eWxlPSJmaWxsOnJnYig1MCw1MCw1MCk7Ii8+CiAgICAgICAgPC9nPgogICAgPC9nPgo8L3N2Zz4K" />',
                data: [],
                columns: [],
                filters: [],
                page: 1,
                pages: [],
                total: 0,
                itemsPerPage: 10,
                watchPageChange: true,
                itemsPerPageOptions: [10, 25, 50, 100]
            }
        },
        mounted() {
            this.fetchData(false);
        },
        methods: {
            gotoFirstPage: function() {
                this.page = 1;
            },
            gotoLastPage: function() {
                this.page = this.pages.length;
            },
            gotoPreviousPage: function() {
                if (this.page > 1) {
                    this.page--;
                }
            },
            gotoNextPage: function() {
                if (this.page < this.pages.length) {
                    this.page++;
                }
            },
            fetchDataFromFilterButtonPress: function() {
                this.watchPageChange = false;
                this.page = 1;
                return this.fetchData(false);
            },
            fetchData: function(tableOnly) {
                if (tableOnly) {
                    this.tableLoading = true;
                } else {
                    this.loading = true;
                }
                window.axios.get(this.operationsUrl, {params: {
                        action: 'fetchData', filters: this.filterData, pagination: this.paginationData
                }}).then((response) => {
                        this.data = response.data.data;
                        this.total = response.data.total;
                        if (!tableOnly) {
                            this.watchPageChange = false;
                            this.columns = response.data.columns;
                            this.filters = response.data.filters;
                            if (this.showPagination) {
                                this.page = 1;
                                let pages = Math.ceil(response.data.total / this.itemsPerPage);
                                this.pages = [];
                                for (let t = 1; t <= pages; t++) {
                                    this.pages.push(t);
                                }
                            }
                        }
                        this.loading = false;
                        this.tableLoading = false;
                        this.watchPageChange = true;
                    })
                    .catch((error) => {
                        console.log(error);
                        //alert(error.response.data)
                        this.loading = false;
                        this.tableLoading = false;
                        this.watchPageChange = true;
                    })
            },
            combinedTdclass: function($column) {
                return this.tdClass+' ajaxtable-'+$column;
            }
        },
        computed: {
            filterData: function() {
                let result = {};
                this.filters.forEach((filter) => {
                    result[filter['field']] = filter['value'];
                });

                return result;
            },
            paginationData: function() {
                return {
                    page: this.page,
                    itemsPerPage: this.itemsPerPage
                }
            }
        },
        watch: {
            page: function() {
                if (this.watchPageChange) {
                    this.fetchData(true);
                }
            },
            itemsPerPage: function() {
                this.fetchDataFromFilterButtonPress();
            }
        }

    }
</script>
