<template>
    <div class="uploader-block bg-white-300 flex justify-center items-center px-3 py-2 max-w-full
                dark:placeholder-gray-400 dark:bg-slate-800 border-gray-700">
        <div class="w-[320px] grid gap-2">
            <div class="h-24 cursor-pointer relative flex justify-center items-center border-2 rounded-md bg-gray-200">
                <input ref="fileInput" class="opacity-0 cursor-pointer h-full w-full"
                       type="file" :name="name" :accept="acceptFile"
                        @input="this.addedFile = $event.target.files[0]">
                <div v-show="previewSrc" class="absolute flex justify-center items-center gap-2">
                    <img v-show="previewSrc" :src="previewSrc"  class="h-20 w-30">
                </div>
            </div>
            <button type="button" v-show="!previewSrc" class="button add-btn" @click="selectFile">Select Image</button>
            <button type="button" v-show="previewSrc" class="button delete-btn" @click="removeFile">Delete</button>
        </div>
        <p v-if="errorMessage" class="error-massage">File max size {{maxSize}}MB</p>
    </div>
</template>

<script>
import { mdiUpload, mdiArrowLeftBoldOutline } from "@mdi/js"
export default {
    name: 'Uploader',
    props: {
        classes: {
            default: '',
            type: String,
        },
        name: {
            default: '',
            type: String,
        },
        file: {
            default: '',

        },
        files: {
            default: null,
            type: Array,
        },
        isMultiple:{
            default: false,
            type: Boolean,
        },
        addIcon: {
            default: 'fa fa-upload',
            type: String,
        },
        editIcon: {
            default: 'fa fa-trash',
            type: String,
        },
        label: {
            default: '',
            type: String,
        },
        deleteLabel:{
            default: 'Delete',
            type: String,
        },
        accept: {
            default: 'image',
            type: String,
        },
        docTyps:{
            default: '.doc,.docx,.pdf,.xlsx, .xls ,.ppt, .pptx',
            type: String,
        },
        maxSize:{
            default: null,
            type: String,
        }
    },
    data: () => ({
        addedFile: null,
        addedFiles:null,
        removed: false,
        staticImages: null,
        errorMessage:false,
        eventStore:null
    }),
    created(){
        this.files ? this.addedFiles=this.files : this.addedFiles= null

    },
    computed: {
        previewSrc() {
            if (! this.addedFile) {
                return this.removed ? false : this.file;
            }
            return URL.createObjectURL(this.addedFile);
        },
        acceptFile(){
            let type = null
            if( this.accept == 'image' ){
                type = 'image/*'
            }else if( this.accept == 'file' ){
                type = '.doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                this.staticImages = '/admin/img/staticImages/file.svg'
            }else if( this.accept == 'video' ){
                type = 'video/*'
                this.staticImages = '/admin/img/staticImages/video.svg'
            }else if( this.accept == 'audio' ){
                type = 'audio/*'
                this.staticImages = '/admin/img/staticImages/audio.svg'
            }else if( this.accept == 'pdf' ){
                type = '.pdf'
                this.staticImages = '/admin/img/staticImages/pdf.svg'
            }
            else if( this.accept == 'word' ){
                type = '.doc, .docx'
                this.staticImages = '/admin/img/staticImages/word.svg'
            }
            else if( this.accept == 'excel' ){
                type = '.xlsx, .xls'
                this.staticImages = '/admin/img/staticImages/excel.svg'
            }
            else if( this.accept == 'zip' ){
                type = 'zip,application/zip,application/x-zip,application/x-zip-compressed'
                this.staticImages = '/admin/img/staticImages/zip.svg'
            }
            else if( this.accept == 'ppt' ){
                type = '.ppt, .pptx'
                this.staticImages = '/admin/img/staticImages/ppt.svg'
            }else if( this.accept == 'doc' ){
                type = this.docTyps
                this.staticImages = '/admin/img/staticImages/file.svg'
            }

            return type
        }
    },
    methods: {
        inputChanged(event) {
            this.$emit('input', event.target.files);
            this.$emit('valueChanged', event.target.files[0])
            this.addedFile = event.target.files[0];
            this.removed = false;
        },
        selectFile() {
            this.$refs.fileInput.click();
        },
        removeFile() {
            this.$refs.fileInput.value = '';
            this.addedFile = null;
            this.addedFiles = null;
            this.removed = true;
            this.$emit('valueChanged', '')
        },
        bytesToMegaBytes(bytes) {
            return (bytes / (1024*1024)).toFixed(2);
        },
        validateSize(file){
            if(!file){
                if(this.bytesToMegaBytes(this.addedFile.size) >= this.maxSize && this.maxSize !== null ){
                    this.removeFile()
                    this.errorMessage = true
                }else{
                    this.errorMessage = false
                }
            }else{
                if(this.bytesToMegaBytes(this.file.size) >= this.maxSize && this.maxSize !== null ){
                    this.removeFile()
                    this.errorMessage = true
                }else{
                    this.errorMessage = false
                }
            }

        },
        multiPreviewSrc(image){
            let url_img = null
            if(this.files){
                if (this.files === this.addedFiles) {
                    url_img = image;
                }else{
                    url_img = URL.createObjectURL(image);
                }
            }else{
                return URL.createObjectURL(image);
            }
            return url_img
        },
    },

};
</script>
<style scoped>
.uploader-block{
    height: 250px;
}

.error-massage{
    font-size: 0.7rem;
    color: #f00;
    font-weight: bold;
}
</style>
