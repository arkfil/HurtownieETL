import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { Router } from '@angular/router';
import {EtlService} from '../etl.service';

@Component({
  selector: 'app-datapresenter',
  templateUrl: './datapresenter.component.html',
  styleUrls: ['./datapresenter.component.css']
})
export class DatapresenterComponent implements OnInit {
  etlData: any;

  constructor(private route: ActivatedRoute, private router: Router, private _etl: EtlService) {
   }

  ngOnInit() {
    this._etl.etlData.subscribe(res => this.etlData = res);
  }
sendMeHome(){
  this.router.navigate([''])
  }

}
