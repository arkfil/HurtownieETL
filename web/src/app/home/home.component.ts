import { Component, OnInit } from '@angular/core';
import { trigger, style, transition, animate, keyframes,query,stagger } from '@angular/animations'
import {EtlService} from '../etl.service'
import { Router } from '@angular/router';
@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {

  constructor(private router : Router) { }

  ngOnInit() {
   }

   takeMeTo(componentName: string, event : MouseEvent){
    event.preventDefault();
    this.router.navigate([componentName]);
  }
}
