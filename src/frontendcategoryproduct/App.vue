<template>
    <div>
        <v-container class="grey lighten-5">
            <div v-if="dataresult.length > 0">
                <v-row no-gutters>
                    <!-------Column start------->
                    <v-col
                            cols="12"
                            xs="6"
                            sm="6"
                            md="6"
                            lg="3"
                            xl="3"
                            class="p-1 d-flex flex-column margin-top"
                            v-for="(item, index) in dataresult"
                            :key="index"
                    >
                        <v-card>
                            <div v-if="item.sale.length > 0">
                                <div class="icon-ofert">Oferta</div>
                            </div>
                            <div v-if="item.url_image != false">
                                <a :href="item.guid">
                                    <figure class="image is-128x128 is-center">
                                        <img :src="item.url_image" :alt="item.title"/>
                                    </figure>
                                </a>
                            </div>
                            <div v-else>
                                <a :href="item.guid">
                                    <figure class="image is-128x128 is-center">
                                        <img
                                                src="https://via.placeholder.com/250x250"
                                                alt="not-image"
                                        />
                                    </figure>
                                </a>
                            </div>
                        </v-card>
                        <v-card>
                            <div v-if="item.reseller[0].title.length > 0">
                                <v-row style="margin-top: -55px; margin-bottom: -10px">
                                    <v-col sm="4">
                                        <div v-for="(value, index) in item.reseller" :key="index">
                                            <div v-if="value.url_image.length > 0">
                                                <figure class="image-reseller  image is-64x64 align-content-center">
                                                    <img
                                                            class="is-rounded"
                                                            :src="value.url_image"
                                                            :alt="value.title"
                                                    />
                                                </figure>
                                            </div>
                                            <div v-else>
                                                <figure class="image-reseller  image is-64x64 align-content-center">
                                                    <img
                                                            class="is-rounded"
                                                            src="https://via.placeholder.com/128x128"
                                                            alt="not-image"
                                                    />
                                                </figure>
                                            </div>
                                        </div>
                                    </v-col>
                                    <v-col sm="8">
                                        <div class="description-reseller-list">
                                            <h6 class="category-tendero">
                                                <a :href="item.reseller[0].category[0].url">{{
                                                    item.reseller[0].category[0].title
                                                    }}</a>
                                            </h6>
                                            <h4 class="category-title-tendero">
                                                {{ item.reseller[0].title }}
                                            </h4>
                                        </div>
                                    </v-col>
                                </v-row>
                            </div>
                            <div v-else></div>
                        </v-card>
                        <v-card class="flex d-flex flex-column padding-card">
                            <v-row>
                                <v-col sm="7">
                                    <h2 style="font-size: 14px">{{ item.title }}</h2>
                                </v-col>
                                <v-col sm="5">
                                    <div v-if="item.product_type === 'simple'">
                                        <div v-if="item.sale.length > 0">
                                            <p v-html="item.qurency.sale"></p>
                                            <p
                                                    style="text-decoration: line-through"
                                                    v-html="item.qurency.price"
                                            ></p>
                                        </div>
                                        <div v-else>
                                            <p v-html="item.qurency.price"></p>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <p v-html="item.product_type_price"></p>
                                    </div>
                                </v-col>
                            </v-row>
                            <div col="12">
                                <ul class="list-category">
                                    <li v-for="(category, index) in item.category" :key="index">
                                        <a :href="category.url">{{ category.title }}</a>
                                    </li>
                                </ul>
                            </div>
                        </v-card>
                        <v-card>
                            <div v-if="item.product_type === 'simple'">
                                <form class="cart">
                                    <input style="display:none" name="product_id" :value="item.id"/>
                                    <input style="display:none" name="quantity" value="1"/>
                                    <v-btn
                                            class="single_add_to_cart_button_success"
                                            :attr-id="item.reseller[0].id"
                                    >Añadir Carrito
                                    </v-btn
                                    >
                                </form>
                            </div>
                            <div v-else>
                                <a :href="item.guid"
                                   class="btn_go_product v-btn v-btn--contained theme--light v-size--default">
                                    <span class="v-btn__content">Ir al Producto</span> </a>
                            </div>
                        </v-card>
                    </v-col>
                    <!-------Column start------->
                </v-row>
                <div class="text-center">
                    <v-pagination
                            v-model="paged"
                            :length="result_lenght"
                            :total-visible="7"
                            @input="actionPage"
                    ></v-pagination>
                </div>
            </div>
            <div v-else>
                <h3 class="text-not-result">No hay resultados en la consulta</h3>
                <v-btn @click="_goToBack" class="center-align">Volver</v-btn>
            </div>
        </v-container>
        <div class="background-loader" v-show="loader === true">
            <div class="container">
                <div class="lds-ripple">
                    <div></div>
                    <div></div>
                </div>
                <p>Cargando...</p>
            </div>
        </div>
    </div>
</template>

<script>
    import {app} from "../../assets/js/script_params";
    import "../config/urlApi";
    import axios from "axios";

    export default {
        name: "App",
        data() {
            return {
                dataresult: [],
                loader: false,
                paged: 1,
                per_paged: 20,
                result_lenght: 0,
            };
        },

        mounted() {
            this.consultData(this.paged, this.per_paged);
        },

        methods: {
            actionPage(page) {
                this.paged = page;
                this.consultData(this.paged, this.per_paged);
            },

            consultData(paged, per_paged) {
                let taxonomy = app.taxonomy;
                let term = app.term;

                this.loader = true;

                axios
                    .post(this.urlCategoryProduct, {
                        taxonomy,
                        term,
                        paged,
                        per_paged,
                    })
                    .then((res) => {
                        this.result_lenght = Math.ceil(
                            res.data[0].number_result / this.per_paged
                        );
                        this.dataresult = res.data;
                    })
                    .catch((error) => {
                        console.log(`Error en la consulta: ${error}`);
                    })
                    .finally(() => {
                        console.log("Se ha finalizado la consulta.");
                        this.loader = false;
                        console.log(dataresult);
                    });
            },
            _goToBack() {
                history.back();
            }
        },
    };
</script>

