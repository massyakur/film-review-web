<template>
<!-- template blogs -->
  <v-container class="ma-0 pa-0" grid-list-sm>

    <div class="text-right">
      <v-btn small text to="/films" class="blue--text">
          All Films <v-icon>mdi-chevron-right</v-icon>
      </v-btn>
    </div>
    <v-layout wrap>
      <blog-item-component 
          v-for="blog in blogs" 
          :key="`blog-`+blog.id"
          :blog="blog" >
      </blog-item-component>
    </v-layout>

  </v-container>

</template>
 
<script>
  import BlogItemComponent from '../components/BlogItemComponent.vue';

  export default {
    data: () => ({
      apiDomain : 'http://demo-api-vue.sanbercloud.com',
      blogs: [],
    }), 
    components : {
      'blog-item-component' : BlogItemComponent,
    },
    created(){
      // console.log(this.$store.state.count)
      const config = {
        method : 'get',
        url : this.apiDomain + '/api/v2/blog/random/4'
      }

      this.axios(config)
      .then(response => {
        let {blogs} = response.data;
        this.blogs = blogs;
        // console.log(this.blogs)
      })
      .catch(error => {
        console.log(error)
      });
    }
  }
</script>