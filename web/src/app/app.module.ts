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

import { AppBootstrapModule } from './app-bootstrap.module';
import { DatapresenterComponent } from './datapresenter/datapresenter.component';



@NgModule({
  declarations: [
    AppComponent,
    HomeComponent,
    AboutComponent,
    EtlComponent,
    DatapresenterComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    FormsModule,
    BrowserAnimationsModule,
    AppBootstrapModule
  ],
  providers: [EtlService],
  bootstrap: [AppComponent]
})
export class AppModule { }
