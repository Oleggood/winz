<i18n>
{
    "ru": {
        "txt1": "Enter для выбора",
        "txt2": "Enter для выбора группы",
        "txt3": "Enter для удаления",
        "txt4": "Enter для удаления группы",
        "txt5": "Выбрано",
        "txt6": "Не найдено",
        "confirm_transport": "Вы уверены, что хотите выбрать транспорт, не связанный с маршрутом?"
    },
    "en": {
        "txt1": "Press enter to select",
        "txt2": "Press enter to select group",
        "txt3": "Press enter to remove",
        "txt4": "Press enter to deselect group",
        "txt5": "Selected",
        "txt6": "No elements found",
        "confirm_transport": "Transport has not been associated with the route. Choose it?"
    }
}
</i18n>
<template>
    <div>
        <div class="relative form-item form-item_select"
             :class="[(this.errorLocal && this.errorLocal.length) ? 'form-item_select_error': '']">
            <multiselect v-if="group"
                         v-model="selected"
                         :options="values"
                         :group-select="group"
                         :multiple="multiple"
                         track-by="id"
                         label="name"
                         :placeholder="' '"
                         :selectLabel="$t('txt1')"
                         :selectGroupLabel="$t('txt2')"
                         :deselectLabel="$t('txt3')"
                         :deselectGroupLabel="$t('txt4')"
                         :selectedLabel="$t('txt5')"
                         group-label="name"
                         @input="changeValue"
                         @select="checkRecommended"
                         group-values="items">
                <span slot="noResult">{{ $t('txt6') }}</span>
                <template slot="option" slot-scope="props">
                    <div class="multiselect__opt-inner"
                         :class="{'multiselect__opt-inner_not-recommend': props.option.not_recommended}">
                        <span v-if="props.option.$isLabel">{{ props.option.$groupLabel }}</span>
                        <span class="multiselect__svg" v-html="props.option.svg"></span>
                        <span>{{ props.option.name }}</span>
                    </div>
                </template>
            </multiselect>
            <multiselect v-else
                         v-model="selected"
                         :options="values"
                         :multiple="multiple"
                         track-by="id"
                         :placeholder="' '"
                         :selectLabel="noEnterLabel ? '' : $t('txt1')"
                         :deselectLabel="noEnterLabel ? '' : $t('txt3')"
                         :selectedLabel="noEnterLabel ? '' : $t('txt5')"
                         @input="changeValue"
                         label="name">
                <span slot="noResult">{{ $t('txt6') }}</span>
                <template slot="option" slot-scope="props">
                    <div class="multiselect__opt-inner">
                        <span>{{ props.option.name }}</span>
                    </div>
                </template>
            </multiselect>

            <div class="label-abs"
                 :class="[this.label_top ? 'label-abs_top'  : '']">
                {{ this.label }}
            </div>
            <div class="form-item__clear" v-if="this.label_top"
                 @click="clearValue">
                <svg>
                    <use xlink:href="#ico-close"></use>
                </svg>
            </div>
        </div>
        <div class="form-item_select__error" v-if="this.errorLocal">{{ this.errorLocal[0] }}</div>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect'

export default {
    components: {
        Multiselect
    },
    name: "BlockSelect",
    props: {
        enabled: Array,
        disabled_options: Array,
        label: String,
        values: [],
        value: [] || '',
        error: Array,
        group: {
            type: Boolean,
            default: false
        },
        multiple: {
            type: Boolean,
            default: false
        },
        noEnterLabel: false,
    },
    data() {
        return {
            selected_id: this.value,
            label_top: false,
            errorLocal: this.error,
            selected: null
        }
    },
    mounted() {
        window.initTooltip();
        this.setValue();
        this.checkLabel();
        this.setRecommended()
    },
    methods: {
        setRecommended() {
            if (this.enabled && this.enabled.length) {
                for (let i in this.values) {
                    for (let j in this.values[i].items) {
                        if (this.enabled.indexOf(this.values[i].items[j].id) === -1) {
                            this.values[i].items[j].not_recommended = true
                        }
                    }
                }
            }
        },
        checkRecommended(item) {
            if (item.not_recommended) {
                Swal.fire({
                    text: this.$t('confirm_transport'),
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#ddd',
                    confirmButtonText: this.$t('text.yes'),
                    cancelButtonText: this.$t('text.no')
                }).then((result) => {
                    if (!result.isConfirmed) {
                        for (let i in this.selected) {
                            if (item.id === this.selected[i].id)
                                this.selected.splice(i, 1);
                        }
                    }
                })
            }
        },
        clearValue() {
            this.selected = this.multiple ? [] : '';
            this.changeValue();
        },
        setValue() {
            this.selected_id = this.value;
            let search = [];
            if (this.selected_id) {
                if (this.group) {
                    for (let i in this.values) {
                        search = search.concat(this.values[i].items)
                    }
                } else {
                    search = this.values;
                }
                if (this.multiple) {
                    this.selected = [];
                    for (let i in search) {
                        if (search[i].id && this.selected_id.indexOf(search[i].id) > -1) {
                            this.selected.push(search[i]);
                        }
                    }
                } else {
                    this.selected = null;
                    for (let i in search) {
                        if (search[i].id == this.selected_id)
                            this.selected = search[i]
                    }
                }
            }
        },
        changeValue() {
            if (this.multiple) {
                this.selected_id = [];
                if (this.selected && this.selected.length) {
                    for (let i in this.selected) {
                        this.selected_id.push(this.selected[i].id)
                    }
                }
            } else {
                this.selected_id = null
                if (this.selected && Object.keys(this.selected).length) {
                    this.selected_id = this.selected.id
                }
            }
            this.$emit('input', this.selected_id)
        },
        checkLabel() {
            if (this.multiple) {
                this.label_top = !!(this.selected_id && Object.keys(this.selected).length);
            } else {
                this.label_top = !!this.selected_id || this.selected_id === 0;
            }
            if (this.label_top)
                this.errorLocal = [];
        },
    },
    watch: {
        value: function () {
            this.setValue();
        },
        values: function () {
            this.setValue();
        },
        selected_id: function () {
            this.checkLabel();
        },
        error: function () {
            this.errorLocal = this.error;
        },
        disabled_options: function () {
            for (let i in this.values) {
                this.values[i].$isDisabled = false;
            }
            let search = [];
            for (let i in this.disabled_options) {
                search.push(this.disabled_options[i].id)
            }
            for (let i in this.values) {
                if (search.indexOf(this.values[i].id) >= 0) {
                    this.values[i].$isDisabled = true
                    if (this.selected_id == this.values[i].id) {
                        this.selected_id = null;
                        this.selected = null;
                    }
                }
            }

        }
    }
}
</script>

<style scoped>

</style>
