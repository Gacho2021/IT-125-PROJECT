/**
 * quantile /quickfacts/assets/images/
 */
div.qf-quantile {
  background: #edeff0;
}
div.qf-quantile > div:nth-child(1) {
  display: inline-block;
  white-space: nowrap;
  padding: 5px;
}
div.qf-quantile > div:nth-child(1) > div {
  display: inline-block;
}
div.qf-quantile > div:nth-child(1) > div > div {
  display: inline-block;  
}
div.qf-quantile > div:nth-child(1) > div > div > span {
  display: inline-block;
  height: 15px;
  font-size: 11px;
  line-height: 15px;
}
div.qf-quantile > div:nth-child(1) > div > div >  span:nth-child(1) {
  border: 1px solid #979fa3;
  border-radius: 4px;
  margin-right: 5px;
  opacity: 0.7;
  width: 15px;
}

/* make empy div visible */
div.qf-quantile > div:nth-child(1) > div > div >  span:nth-child(1):after {
  content: '.';
  visibility: hidden;
}
div.qf-quantile div.qf-values span.qf-min {
  margin-right: 5px;
}
div.qf-quantile div.qf-values span.qf-max {
  margin-left: 5px;
}

div.qf-quantile div.qf-quantile-note {
  display: block;
  font-size: 11px;
  line-height: 14px;
  text-align: center;
  padding: 0 0 10px 0;
  margin: 0;
}
div.qf-quantile > div.qf-quantile-note > div {
  display: flex;
  align-items: center;
  justify-content: center;
  line-height: 30px;
  margin-top: 5px;
}
div.qf-quantile > div.qf-quantile-note > div > span {
  display: inline-block;
  height: 30px;
  width: 30px;
  border: 1px solid #979fa3;
  border-radius: 4px;
  margin-right: 5px;
  margin-left: 15px;
  opacity: 0.7;
  line-height: 30px;
}
div.qf-quantile > div.qf-quantile-note > div > span:nth-child(1) {
  background-image: url(/quickfacts/assets/images/diag-striping-blue.png);
}
div.qf-quantile > div.qf-quantile-note > div > span:nth-child(2) {
  background-image: url(/quickfacts/assets/images/diag-striping.png);
}