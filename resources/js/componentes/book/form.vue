<template>
    <div class="modal" tabindex="-1" id="modalBook">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo Libro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="storeBook" type="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Titulo</label>
                            <input type="text" class="form-control" placeholder="Ingrese el titulo" v-model="book.title"  v-bind="book"  required>
                        </div>
                        <div class="form-group">
                            <label>Paginas</label>
                            <input type="text" class="form-control" placeholder="Ingrese el numero de paginas" v-model="book.pages" v-bind="book"  required >
                        </div>
                        <div class="form-group">
                            <label>Lenguaje</label>
                            <input type="text" class="form-control" placeholder="Ingrese el lenguaje del libro" v-model="book.language" v-bind="book"  required>
                        </div>
                        <div class="form-group">
                            <label>Fecha de publicacion</label>
                            <input type="date" class="form-control" v-model="book.publication_date"  v-bind="book" required>
                        </div>
                        <div class="form-group">
                            <label>Precio</label>
                            <textarea class="form-control" placeholder="agregue el precio" v-model="book.price" v-bind="book"  required></textarea>
                        </div>
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <label>image</label>
                                <img :src="`${photo}`" alt="avatar" style="width: 10rem;" v-if="showPreview">
                                <input type="file" id="user-photo" accept="image/*" v-on:change="previewFile">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="publisher_id">Seleccione la editorial</label>
                            <select  class="form-control" name="publisher_id" id="publisher_id" required v-model="book.publisher_id">
                                <option :value="`${publisher.id}`"  v-for="(publisher,index) in $parent.publishers" :key="index">{{publisher.name}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="genre_id">Seleccione el genero</label>
                            <select class="form-control" name="genre_id" id="genre_id" required v-model="book.genre_id">
                                <option :value="`${genre.id}`"   v-for="(genre,index) in $parent.genres" :key="index">{{genre.name}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="author_id">Seleccione el autor</label>
                            <select class="form-control" name="author_id" id="author_id" required v-model="book.author_id">
                                <option :value="`${author.id}`"   v-for="(author,index) in $parent.authors" :key="index">{{author.sur_name}}</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </template>

<script>
    export default {
        props: ['book'],
        data(){
           return{
               showPreview: false,
               photo: null,
               file: '',
           }
        },
        mounted(){
            if(this.book.id){
                this.showPreview = true
                this.photo = this.book.image
            }
        },
        methods: {
            formDataTable(){
                const formData=new FormData()
                console.log(this.file)
                formData.append('image', this.file, this.file.name)
                formData.append('title',this.book.title)
                formData.append('pages',this.book.pages)
                formData.append('language',this.book.language)
                formData.append('publication_date',this.book.publication_date)
                formData.append('price',this.book.price)
                formData.append('publisher_id',this.book.publisher_id)
                formData.append('genre_id',this.book.genre_id)
                formData.append('author_id',this.book.author_id)
                return formData
            },
            async storeBook() {
                let formData = this.formDataTable()
                let url = '/books/store'
                let res = null

                if (this.book.id){
                    url = `/books/update/${this.book.id}`
                }
                res = await axios.post(url, formData)
                if (res.data.saved) {
                    alert(`${res.data.message}`)
                }
                // if(!this.book.id){
                //     this.$parent.$parent.books_news.push(res.data.book)
                // }
                this.$parent.closeModal()
            },

            async previewFile(event) {
                this.file = event.target.files[0]
                this.photo = URL.createObjectURL(this.file)
                this.showPreview = true
            },
        },
    }
</script>

