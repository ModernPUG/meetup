import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import {Http, HttpModule} from '@angular/http';

import { AppComponent } from './app.component';
import { OneComponent } from './one/one.component';
import { TwoComponent } from './two/two.component';
import { PageNotFoundComponent } from './page-not-found/page-not-found.component';
import {AppRoutingModule} from './app-routing.module';
import {OneSvcService} from './service/one-svc.service';
import {AppProvider} from './app-provider';

@NgModule({
  declarations: [
    AppComponent,
    OneComponent,
    TwoComponent,
    PageNotFoundComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    HttpModule,
    AppRoutingModule
  ],
  providers: [
    { provide: OneSvcService , useFactory: AppProvider.getOneSvc , deps: [Http] } ,
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
