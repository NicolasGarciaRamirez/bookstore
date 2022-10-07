<template >
    <div class="table-responsive">
        <table class="table table-hover text-center" id="bookTabla">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Titulo</th>
                    <th># paginas</th>
                    <th>Idioma</th>
                    <th>Fecha de publicacion</th>
                    <th>Precio</th>
                    <th>Imagen</th>
                    <th>Editorial</th>
                    <th>Genero</th>
                    <th>Author</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(book, index) in books" :key="index">
                    <td>{{book.id}}</td>
                    <td>{{book.title}}</td>
                    <td>{{book.pages}}</td>
                    <td>{{book.language}}</td>
                    <td>{{book.publication_date}}</td>
                    <td>{{book.price}}</td>
                    <td>
                        <img :src="book.image" alt="image" class="img-fluid">
                    </td>
                    <td>{{book.publisher.name}}</td>
                    <td>{{book.genre.name}}</td>
                    <td>{{book.author.sur_name}} {{book.author.last_name}}</td>
                    <td>
                        <a class="btn btn-warning" href="#" @click.prevent="editBook(book)">Editar</a>
                        <a class="btn btn-danger" href="#" @click.prevent="borrarBook(index)">Borrar</a>
                    </td>
                </tr>
            </tbody>
        </table>
        <div v-if="load_modal">
            <book-form :book="book"></book-form>
        </div>
    </div>
</template>

<script>

import BookForm from './form'
export default {
    props:['books'],
    components:{
        BookForm
    },
    data(){
        return{
            book: {},
            genres: [],
            publishers: [],
            authors: [],
            image: '',
            load_modal: false
        }
    },
    mounted(){
        this.getData()
        this.tabla()

    },
    methods:{
        editBook(book){
            this.load_modal = true
            this.book = book
            setTimeout(() => {
                $('#modalBook').modal('show')
            }, 200);
        },

        createBook() {
            this.load_modal = true
            this.book = {}
            setTimeout(() => {
                $('#modalBook').modal('show')
            }, 200);
        },

        closeModal() {
            $('#modalBook').modal('hide')
            setTimeout(() => {
                this.load_modal = false
            }, 200);
        },

        getData(){
            axios.get('/api/getData').then(res=>{
                this.genres = res.data.genres
                this.publishers = res.data.publishers
                this.authors = res.data.authors
            });
        },

        async borrarBook(book_id){
            if (!confirm('¿desea eliminar el registro')) return;
            await axios.delete(`/books/delete/${book_id}`).then(res=>{
                if(res.data.deleted){
                    let index = _.findIndex(this.books, function (o) {return o.id === book_id})
                    this.books.splice(index, 1);
                }
            })
        },

        tabla(){
            setTimeout(() => {
                $('#bookTabla').DataTable({
                    dom: 'Bfrtip',
                    buttons: ['copy', 'excel'],
                    processing: true
                })
            }, 1000)
        },
    }
}
</script>
