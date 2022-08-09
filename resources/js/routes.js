import NotFound from './components/NotFound';
import Home from './components/Home';
import Auth from './Auth.js';
import Departments from './components/Departments';
import Departments_Details from './components/Departments_Details';
import Doctors from './components/Doctors';
import Doctors_Details from './components/Doctors_Details';
import ListAppointment  from './components/ListAppointment';
import Appointment  from './components/Appointment';
import ConfAppointment  from './components/ConfAppointment';
import DetailsAppointment  from './components/DetailsAppointment';
import Login from './components/Login';
import Register from './components/Register';
import Profile from './components/Profile';

export default {
    mode: 'history',

    linkActiveClass: 'link-active',

    routes: [
        {
            path: '*',
            redirect() {
                if(document.documentElement.lang.substr(0, 2) == 'en'){
                    return 'en';
                }
                return 'ar';
            }
        },
        {

            path: '/:lang/',
            component: {
                template: '<router-view v-bind:key="$route.fullPath"></router-view>'
            },
            beforeEnter: (to, from, next) => { // <------------
                const locale = to.params.lang; // 1
                console.log('loc:',to);
                const supported_locales = ['en','ar']; // 2
                if (!supported_locales.includes(locale)){
                    if(document.documentElement.lang.substr(0, 2) == 'en'){
                        return next('en');
                    }
                    return next('ar');
                }  // 3
                return next(); // 5
            },
            children: [
                {
                    path: '/:lang/',
                    name: 'home',
                    component: Home
                },

                {
                    path: '/:lang/our-departments',
                    name: 'departments',
                    component: Departments
                },
                {
                    path: '/:lang/our-departments-details/:id',
                    name: 'departments_details',
                    component: Departments_Details,
                    props: true
                },
                {
                    path: '/:lang/our-doctors',
                    name: 'doctors',
                    component: Doctors
                },
                {
                    path: '/:lang/our-doctors-details/:id',
                    name: 'doctors_details',
                    component: Doctors_Details,
                    props: true
                },
                {
                    path: '/:lang/register',
                    name: 'register',
                    component: Register
                },

                {
                    path: '/:lang/profile',
                    name: 'profile',
                    component: Profile
                },
                {
                    path: '/:lang/login',
                    name: 'login',
                    component: Login
                },
                {
                    path: '/:lang/appointment',
                    name: 'appointment',
                    component: Appointment
                },
                {
                    path: '/:lang/appointment/conf/:id',
                    name: 'confappointment',
                    component: ConfAppointment
                },
                {
                    path: '/:lang/appointment/details/:id',
                    name: 'detailsAppointment',
                    component: DetailsAppointment
                },
                {
                    path: '/:lang/listappointment',
                    name: 'listappointment',
                    component: ListAppointment
                },
                {
                    path: '/:lang/doctors-appointment/:depart_id/:doc_id',
                    name: 'appointment_doctors',
                    component: Appointment,
                    props: true
                }

            ]
        }
    ]
}
