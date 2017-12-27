import { Component, OnInit, Injectable } from '@angular/core';
import { EtlService } from '../etl.service';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-etl',
  templateUrl: './etl.component.html',
  styleUrls: ['./etl.component.css']
})

@Injectable() 
export class EtlComponent implements OnInit {

  constructor( private _etlService:EtlService ) { }

  productId : string = "52408449";
  public etlJson;

  ngOnInit() {
    this._etlService.etlData.subscribe(res=> this.etlJson = res);
  }
  etlRequest() {
    this._etlService.getData(this.productId);
 

  }

}
