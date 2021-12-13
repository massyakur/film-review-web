<template>
  <v-container class="ma-0 pa-0" grid-list-sm>
    <v-subheader>
      All Films
    </v-subheader>

    <v-layout wrap>
      <v-flex v-for="blog in blogs" :key="`blog-`+blog.id" xs6>

        <v-card :to="`/blog/` + blog.id">

          <v-img :src="blog.photo ? apiDomain + blog.photo : 'https://picsum.photos/200/300'"
          class="white--text" height="300px">
            <v-card-title class="fill-height align-end" v-text="blog.title"></v-card-title>            
          </v-img>

          <v-card-actions>
            <v-progress-linear color="blue-grey" height="7"></v-progress-linear>
          </v-card-actions>

          <v-card-actions>
            <span>{{blog.title.substring(0,15)}}...</span>
          </v-card-actions>

        </v-card>
      </v-flex>  
    </v-layout>

    <v-pagination
      v-model="page"
      @input="go"
      :length="lengthPage"
      :total-visible="perPage"> 
    </v-pagination>

  </v-container>
</template>

<script>
  export default {
    data: () => ({
      apiDomain : 'http://demo-api-vue.sanbercloud.com',
      blogs: [],
      page : 0,
      lengthPage : 0,
      perPage : 0,
    }), 

    methods : {
        go() {
          const config = {
            method : 'get',
            url : this.apiDomain + '/api/v2/blog?page=' + this.page
            // params : { 'page' : this.page}
          };    

        this.axios(config)
          .then(response => {
            let {blogs} = response.data
            this.blogs = blogs.data
            this.page = blogs.current_page
            this.lengthPage = blogs.last_page
            this.perPage = blogs.per_page
            // console.log(this.blogs)
          })
        .catch(error => {
          console.log(error)
        });
        }

    },

    created() {
      this.go()
    }  

  };
  
</script>