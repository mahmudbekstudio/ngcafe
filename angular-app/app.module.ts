import { NgModule }      from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule } from '@angular/forms';
import { HttpModule/*, JsonpModule*/ } from '@angular/http';

import { Configuration } from './classes/configuration';
import { Service } from './classes/service';

import { AppComponent }  from './app/component';
import { SystemLogin } from './systemlogin/component';

@NgModule({
  imports:      [
    BrowserModule,
    FormsModule,
    HttpModule,
    //JsonpModule,
  ],
  providers:   [
    Configuration,
    Service
  ],
  declarations: [
    AppComponent,
    SystemLogin
  ],
  bootstrap:    [ AppComponent ]
})
export class AppModule { }
