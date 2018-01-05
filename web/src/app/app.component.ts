import { Component } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'ETL';
  currentYear = new Date().getFullYear();

  constructor (private router: Router){
  }

  takeMeTo(componentName: string, event : MouseEvent){
    event.preventDefault();
    this.router.navigate([componentName]);
  }
}
