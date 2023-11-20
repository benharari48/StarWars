var app = new Vue({
  el: '#app',
  vuetify: new Vuetify(),
  data () {
    return {
      headers: [
        { text: 'name',align: 'start',value: 'name' },
        { text: 'starship class', value: 'starship_class' },
        { text: 'crew', value: 'crew' },
        { text: 'cost in credits', value: 'cost_in_credits' },
      ],
      rows:[],
      loading:true,
    }
  },
  methods:{
    getData(){

      var formData = new FormData();

      formData.append( 'action', 'StarWarsData' );

      fetch( myData.url, {
          method: 'POST',
          body: formData,
      } ) // wrapped
          .then( res => res.text() )
          .then( data => {

            var parse = JSON.parse(data);
          
            app.rows = parse.results;

            app.loading = false;
          
          } )
          .catch( err => console.log( err ) );

    }
  },
  created(){
    this.getData();
  }
});