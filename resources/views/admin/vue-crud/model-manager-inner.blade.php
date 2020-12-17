<model-manager index-url="{!! $indexUrl !!}"
               details-url="{!! $detailsUrl !!}"
               create-url="{!! $createUrl !!}"
               edit-url="{!! $editUrl !!}"
               store-url="{!! $storeUrl !!}"
               update-url="{!! $updateUrl !!}"
               delete-url="{!! $deleteUrl !!}"
               ajax-operations-url="{!! $ajaxOperationsUrl !!}"
               :allow-operations="{{ $allowOperations ? 'true' : 'false' }}"
               :allow-adding="{{ $allowAdding ? 'true' : 'false' }}"
               :auto-filter="false"
               :use-sweet-alert="false"
               subject-name="{{ $subjectName }}"
               :default-filters="{{ json_encode($defaultFilters) }}"
               :class-overrides="{{ json_encode(config('vuecrud.modelManagerClassOverrides')) }}"
               :icon-classes="{{ json_encode([
                            "filter" => "mdi mdi-magnify",
                            "list" => "mdi mdi-format-list-bulleted",
                            "leftArrow" => "mdi mdi-arrow-left-thick",
                            "rightArrow" => "mdi mdi-arrow-right-thick"
                        ]) }}"
               id-property="{{ $idProperty }}"
></model-manager>
