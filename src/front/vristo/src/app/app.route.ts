import { Routes } from '@angular/router';

// dashboard
import { IndexComponent } from './index';
import { AppLayout } from './layouts/app-layout';
import { AuthLayout } from './layouts/auth-layout';
import { LoginComponent } from './pages/login/login.component';
import { AuthSignoutComponent } from './pages/auth-signout/auth-signout.component';
import { UsuariosComponent } from './pages/modulos/usuarios/usuarios/usuarios.component';
import { RolesComponent } from './pages/modulos/roles/roles/roles.component';

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
            { path: '', component: IndexComponent, title: 'Adminstrador de Precios | VRISTO - Dashboard' },
            //usuarios
            {path:'usuarios',component:UsuariosComponent,title:'Administración de Usuarios | VRISTO'},
            //roles
            {path:'roles',component:RolesComponent,title:'Administración de Roles | VRISTO'}
        ],
    },

    {
        path: 'preload',
        component: AuthLayout,
        children: [
        ],
    },
];
