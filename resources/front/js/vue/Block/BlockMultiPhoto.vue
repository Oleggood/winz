<i18n>
{
    "ru": {
        "crt_btn4": "Добавить фото",
        "crt_err1": "Фотография должна быть в формате jpg, png или gif",
        "crt_err2": "Размер фотографии не должен превышать 2 Мб"
    },
    "en": {
        "crt_btn4": "Add photo",
        "crt_err1": "The photo must be in jpg, png or gif format",
        "crt_err2": "Photo size should not exceed 2 MB"
    }
}


</i18n>
<template>
    <div class="flex flex_5 flex-wrap" id="uploadImagesList">
        <div class="mb10 col3 col_5 col6-550" v-for="file in this.old_images">
            <div class="photo1__wrap photo1__wrap-main"
                 v-bind:style="{ 'background-image': 'url(' + file['thumb1'] + ')' }">
                <input type="hidden" v-model="old_images">
                <button class="photo1__remove" @click.prevent="removeOldItem(file['id'])">&times;</button>
            </div>
        </div>
        <div class="mb10 col3 col_5 col6-550" v-for="file in this.files">
            <div class="photo1__wrap photo1__wrap-main"
                 v-bind:style="{ 'background-image': 'url(' + file['thumb1'] + ')' }">
                <input type="hidden" v-model="old_images">
                <button class="photo1__remove" @click.prevent="removeItem(file['id'])">&times;</button>
            </div>
        </div>
        <label class="col3 col_5 mb10 photo1__wrap-add col6-550" v-if="totalImages < max">
            <input type="file" id="addImages" multiple ref="file" v-on:change="uploadFile(0)">
            <span class="photo1__empty">
                <span>
                    <svg width="2.25rem" height="2.25rem">
                        <use xlink:href="#ico-noimage"></use>
                    </svg>
                    <span class="color-dark fz16 fw800">{{ $t('crt_btn4') }}</span>
                </span>
            </span>
        </label>
    </div>
</template>

<script>
export default {
    name: "BlockMultiPhoto",
    props: {
        max: Number
    },
    data() {
        return {
            files: [],
            temp_files: [],
            old_images: [],
            images: {},
            totalImages: Number
        }
    },
    mounted() {
        this.old_images = this.$attrs.files || [];
        this.changeValue();
        this.recalcTotal();
    },
    methods: {
        uploadFile() {
            let component = this;
            this.recalcTotal();
            component.temp_files = component.$refs.file.files;
            let i = 0
            for (i = 0; i < component.temp_files.length; i++) {
                if (i < this.max - component.totalImages) {
                    let clear = false;
                    if (i == component.max - component.totalImages - 1) {
                        clear = true;
                    }
                    let exists = false;
                    for(let key in this.images){
                        if(this.images[key].name == component.temp_files[i].name)
                            exists = true;
                    }
                    if (!exists)
                        component.preview(component.temp_files[i], clear);
                }
            }
            component.totalImages = i + component.totalImages;
            component.temp_files = [];
            this.changeValue();
        },
        removeOldItem(id) {
            for (let i in this.old_images) {
                if (this.old_images[i].id == id) {
                    this.old_images.splice(i, 1);
                }
            }
            this.recalcTotal();
            this.changeValue();
        },
        removeItem(id) {
            for (let i in this.files) {
                if (this.files[i].id == id) {
                    this.files.splice(i, 1);
                }
            }
            this.images = {};
            for (let i in this.files) {
                this.images[this.files[i]['id']] = this.files[i]['file'];
            }
            this.recalcTotal();
            this.changeValue();
        },
        preview(file, clear = false) {
            let component = this;
            if (!file.type.match(/image\/(jpeg|jpg|png|gif)/)) {
                Swal.fire({
                    icon: 'warning',
                    text: this.$t('crt_err1')
                })
            }
            if (file.size > window.maxFileSize) {
                Swal.fire({
                    icon: 'warning',
                    text: this.$t('crt_err2')
                })
            }
            let reader = new FileReader();
            reader.addEventListener('load', function (event) {
                component.files.push({
                    'id': file.name,
                    'thumb1': event.target.result,
                    'file': file,
                })
                component.images[file.name] = file;
            });
            reader.readAsDataURL(file);
            if (clear)
                component.temp_files = [];

        },
        changeValue() {
            let return_ids = []
            for (let i in this.old_images) {
                return_ids.push(this.old_images[i].id)
            }
            this.$emit('input', {
                "images": this.images,
                "old_images": return_ids,
            })
        },
        recalcTotal() {
            this.totalImages = Object.keys(this.old_images).length + Object.keys(this.images).length;
        }
    }
}
</script>

<style scoped>

</style>
