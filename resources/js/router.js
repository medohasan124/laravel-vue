
window.Vue = require('vue').default;
import VueRouter from 'vue-router'
import ExampleComponent from './components/ExampleComponent.vue'
import Users from './components/Users.vue'
import developer from './components/developer.vue'
import profile from './components/profile.vue'

Vue.use(VueRouter)



export default new VueRouter({
	 routes: [
  	{ path: '/Home', component: ExampleComponent },
  	{ path: '/user', component: Users } ,
  	{ path: '/developer', component: developer },
  	{ path: '/profile', component: profile },
  ],
  mode:'history'
})