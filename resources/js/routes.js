import { createRouter, createWebHistory } from 'vue-router'
import Login from './components/auth/login.vue'
import Dashboard from './components/Dashboard.vue'
import Posts from './components/Posts.vue'
import Profile from './components/Profile.vue'
import Signup from './components/auth/signup.vue'
import NotFound from './components/parts/not-found.vue'
import PostsDetail from './components/PostDetail.vue'

const routes = [
    {
        path: '/dashboard',
        name: 'Dashboard',
        component: Dashboard
    },
    {
        path: '/signup',
        name: 'Signup',
        component: Signup
    },
    {
        path: '/',
        name: 'Login',
        component: Login
    },
    {
        path: '/posts',
        name: 'Posts',
        component: Posts
    },
    {
        path: '/posts/:id',
        name: 'PostsDetail',
        component: PostsDetail
    },
    {
        path: '/profile',
        name: 'Profile',
        component: Profile
    },
    { path: '/:pathMatch(.*)*', name: 'NotFound', component: NotFound }
]

const router = createRouter({ history: createWebHistory(), routes })

router.beforeEach(async (to, from, next) => {
    const token = localStorage.getItem('token');

    // If user is trying to access Login or Signup pages and has a token
    if ((to.name === 'Login' || to.name === 'Signup') && token) {
        next({ name: from.name || 'Posts' }); // Redirect to the last visited or Dashboard
    }
    // If user is trying to access any other page and does not have a token
    else if (to.name !== 'Login' && to.name !== 'Signup' && !token) {
        console.log("User is not authenticated, redirecting to Login or Signup.");
        next({ name: 'Login' }); // Redirect to Login page
    }
    // If none of the conditions match, allow access to the route
    else {
        next();
    }
});


export default router
