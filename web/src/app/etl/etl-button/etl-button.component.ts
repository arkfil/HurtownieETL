import { Component, OnInit, Input } from '@angular/core';
import { flowControl } from '../../models';


@Component({
  selector: "etl-button",
  templateUrl: './etl-button.component.html',
  styleUrls: ['./etl-button.component.css'],
})
export class EtlButtonComponent {

  @Input() 
  private buttonFlowControl : flowControl;
  
  constructor() { }

}
