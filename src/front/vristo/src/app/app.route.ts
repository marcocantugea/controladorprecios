import { Routes } from '@angular/router';

// dashboard
import { IndexComponent } from './index';
import { AppLayout } from './layouts/app-layout';
import { AuthLayout } from './layouts/auth-layout';
import { LoginComponent } from './pages/login/login.component';
import { AuthSignoutComponent } from './pages/auth-signout/auth-signout.component';

export const routes: Routes = [
    {
        path:'',
        redirectTo:'login',
        pathMatch:'full'
    },
    {
        path:'auth/signout',
        component:AuthSignoutComponent
    },
    {
        path:'login',
        component:LoginComponent
    },
    {
        path: 'admin',
        component: AppLayout,
        children: [
            // dashboard
            { path: '', component: IndexComponent, title: 'Sales Admin | VRISTO - Multipurpose Tailwind Dashboard Template' },

        ],
    },

    {
        path: '',
        component: AuthLayout,
        children: [
        ],
    },
];
