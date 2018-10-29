import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';


import { AppComponent } from './app.component';
import { SeoService } from './services/seo.service';


@NgModule({
  declarations: [
    AppComponent
  ],
  imports: [
    BrowserModule.withServerTransition({ appId: 'universal' })
  ],
  providers: [SeoService],
  bootstrap: [AppComponent]
})
export class AppModule { }
