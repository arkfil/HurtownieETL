import { Component, OnInit } from '@angular/core';
import { EtlService } from '../etl.service';
import { etlData } from '../models';

@Component({
  selector: 'app-datapresenter',
  templateUrl: './datapresenter.component.html',
  styleUrls: ['./datapresenter.component.css']
})
export class DatapresenterComponent implements OnInit {
  
  etlData: etlData;
  showOpinions: boolean = false;

  constructor(private _etl: EtlService) {
   }

  ngOnInit() {
    this._etl.etlData.subscribe(res => this.etlData = res);
  }

  public decode(text : string) : string {
    return decodeURIComponent(text);
  }

  toggleOpinions(){
    this.showOpinions = !this.showOpinions;
  }
}
