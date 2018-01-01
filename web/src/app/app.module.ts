import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { EtlService } from './etl.service'
import { FormsModule } from '@angular/forms';
import { AppRoutingModule } from './app-routing.module';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';

import { AppComponent } from './app.component';
import { HomeComponent } from './home/home.component';
import { AboutComponent } from './about/about.component';
import { EtlComponent } from './etl/etl.component';
import { EtlButtonComponent } from './etl/etl-button/etl-button.component';
import { DatapresenterComponent } from './datapresenter/datapresenter.component';

import { AppBootstrapModule } from './app-bootstrap.module';

import { HttpClientModule } from '@angular/common/http';
import './models'


@NgModule({
  declarations: [
    AppComponent,
    HomeComponent,
    AboutComponent,
    EtlComponent,
    DatapresenterComponent,
    EtlButtonComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    FormsModule,
    BrowserAnimationsModule,
    AppBootstrapModule,
    HttpClientModule
  ],
  providers: [EtlService],
  bootstrap: [AppComponent]
})
export class AppModule { }
