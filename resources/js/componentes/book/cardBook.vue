<template>
    <section class="d-flex justify-content-between flex-wrap">
        <div id="bookCard" class="card mx-2 my-4" style="width: 17rem; height: 17rem" v-for="(book, index) in books" :key="index" >
            <img src="" class="card-img-top" alt="default"/>
            <div class="card-body">
                <table class="table table-hover text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>users</th>
                        <th>producto</th>
                        <th>Precio</th>
                        <th>cantidad</th>
                        <th>acciones</th>
                    </tr>
                </thead>
                <tbody id="items">
                    <tr v-for="item in carrito" :key="item.id" :item="item">
                        <td>{{book.id}}</td>
                        <td>{{id.users}}</td>
                        <td>{{id.product}}</td>
                        <td>{{precio.carrito}}</td>
                        <td>{{cantidad.carrito}}</td>
                        <td>{{book.price}}</td>
                        <td>
                            <img :src="'/storage/images/authors${libro3.image}'" alt="" class="img-fluid w-25">
                        </td>
                    </tr>
                </tbody>
<!--

                <td class="card-title">{{book.title}}</td>
                <td class="card-text">{{ book.image}}</td>
                <td class="card-text">{{book.author.sur_name}}</td>
                <td class="card-text">{{book.price }}</td>
                <td class="card-text">{{book.publisher.name}}</td>
                <td class="card-text">{{book.genre.name}}</td> -->

                <a href="carrito" class="btn btn-primary">Agregar al carrito</a>
            </table>
            </div>
        </div>
    </section>
</template>
<script>
export default {
    props: ["books"],
    data() {
        return {

        };
    },
    mounted() {
        $("#bookCard");
    },

};
</script>
