import { NgModule } from '@angular/core';
import { BrowserModule, Title } from '@angular/platform-browser';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { RouterModule } from '@angular/router';

//Routes
import { routes } from './app.route';

import { AppComponent } from './app.component';

// service
import { AppService } from './service/app.service';

// store
import { StoreModule } from '@ngrx/store';
import { indexReducer } from './store/index.reducer';

// i18n
import { TranslateLoader, TranslateModule } from '@ngx-translate/core';
import { TranslateHttpLoader } from '@ngx-translate/http-loader';

// headlessui
import { MenuModule } from 'headlessui-angular';

// perfect-scrollbar
import { NgScrollbarModule } from 'ngx-scrollbar';

// dashboard
import { IndexComponent } from './index';

// Layouts
import { AppLayout } from './layouts/app-layout';
import { AuthLayout } from './layouts/auth-layout';

import { HeaderComponent } from './layouts/header';
import { FooterComponent } from './layouts/footer';
import { SidebarComponent } from './layouts/sidebar';
import { ThemeCustomizerComponent } from './layouts/theme-customizer';
import { LoginComponent } from './pages/login/login.component';
import { AuthSignoutComponent } from './pages/auth-signout/auth-signout.component';
import {MatProgressSpinnerModule} from '@angular/material/progress-spinner';
import {MatDialogModule} from '@angular/material/dialog';
import { LoadingComponent } from './components/modal/loading/loading/loading.component';
import { UsuariosComponent } from './pages/modulos/usuarios/usuarios/usuarios.component';
import { UsuarioListadoComponent } from './pages/modulos/usuarios/usuarios/components/usuario-listado/usuario-listado.component';
import { UsuarioAddComponent } from './pages/modulos/usuarios/usuarios/components/usuario-add/usuario-add.component';
import { ConfirmComponent } from './components/modal/confirm/confirm.component';
import { UsuarioChangepasswordComponent } from './pages/modulos/usuarios/usuarios/components/usuario-changepassword/usuario-changepassword.component';
import { ErrorComponent } from './components/modal/error/error.component';

@NgModule({
    imports: [
        RouterModule.forRoot(routes, { scrollPositionRestoration: 'enabled' }),
        BrowserModule,
        BrowserModule,
        BrowserAnimationsModule,
        CommonModule,
        FormsModule,
        ReactiveFormsModule,
        HttpClientModule,
        MenuModule,
        TranslateModule.forRoot({
            loader: {
                provide: TranslateLoader,
                useFactory: httpTranslateLoader,
                deps: [HttpClient],
            },
        }),
        StoreModule.forRoot({ index: indexReducer }),
        NgScrollbarModule.withConfig({
            visibility: 'hover',
            appearance: 'standard',
        }),
        MatProgressSpinnerModule,
        MatDialogModule
    ],
    declarations: [AppComponent, HeaderComponent, FooterComponent, SidebarComponent, ThemeCustomizerComponent, IndexComponent, AppLayout, AuthLayout, LoginComponent, AuthSignoutComponent, LoadingComponent, UsuariosComponent, UsuarioListadoComponent, UsuarioAddComponent, ConfirmComponent, UsuarioChangepasswordComponent, ErrorComponent],
    providers: [AppService, Title],
    bootstrap: [AppComponent],
})
export class AppModule {}

// AOT compilation support
export function httpTranslateLoader(http: HttpClient) {
    return new TranslateHttpLoader(http);
}
