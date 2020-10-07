<script type="text/plain" data-usercentrics="Bing Ads">(function(w,d,t,r,u){var f,n,i;w[u]=w[u]||[],f=function(){var o={ti:"5000183"};o.q=w[u],w[u]=new UET(o),w[u].push("pageLoad")},n=d.createElement(t),n.src=r,n.async=1,n.onload=n.onreadystatechange=function(){var s=this.readyState;s&&s!=="loaded"&&s!=="complete"||(f(),n.onload=n.onreadystatechange=null)},i=d.getElementsByTagName(t)[0],i.parentNode.insertBefore(n,i)})(window,document,"script","//bat.bing.com/bat.js","uetq");</script>

<!-- Global site tag (gtag.js) - Google Ads: 1036286537 -->
<?php $url = $_SERVER['REQUEST_URI']; ?>
<script type="text/plain" data-usercentrics="Google Ads Remarketing"  async src="https://www.googletagmanager.com/gtag/js?id=AW-1036286537"></script>
<script type="text/plain" data-usercentrics="Google Ads Remarketing" >
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'AW-1036286537');  
</script>

<!-- Google Analytics (analytics.js)-->
<script type="text/plain" data-usercentrics="Google Analytics">(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-65392968-1', 'auto');
  ga('send', 'pageview');</script>
    


<!-- Facebook Pixel Code -->
<script  type="text/plain" data-usercentrics="Facebook Pixel">
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '2055007674609702');
        fbq('init', '1549003551902410');
        fbq('track', 'PageView');
    <?php
        if (strstr($url, "/calculation")) {
            print "fbq('track', 'SubmitApplication');";                                                              
        }
        if (strstr($url, "/thankyou")) {
            print "fbq('track', 'Lead');";                                                             
        }
    ?>
    
</script>
<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=2055007674609702&ev=PageView&noscript=1"/></noscript>
<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1549003551902410&ev=PageView&noscript=1"/></noscript>
<!-- End Facebook Pixel Code -->

<script type="text/javascript">
function setCookie(name, value, days){
    var date = new Date();
    date.setTime(date.getTime() + (days*24*60*60*1000));
    var expires = "; expires=" + date.toGMTString();
    document.cookie = name + "=" + value + expires + ";path=/";
}
function getParam(p){
    var match = RegExp('[?&]' + p + '=([^&]*)').exec(window.location.search);
    return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
}
var gclid = getParam('gclid');
var adgroupid = getParam('adgroupid');
var campaignid = getParam('campaignid');
var utm_source = getParam('utm_source');
var utm_keyword = getParam('utm_keyword');
var keyword = getParam('keyword');
var network = getParam('network');       
var utm_medium = getParam('utm_medium');
var matchtype = getParam('matchtype');
var device = getParam('device');
var devicemodel = getParam('devicemodel');     
var adpostion = getParam('adpostion');
 
if(gclid){
    var gclsrc = getParam('gclsrc');
    if(!gclsrc || gclsrc.indexOf('aw') !== -1){
      setCookie('gclid', gclid, 90);
    }
 
    if(adgroupid.length > 0 )   {setCookie('adgroupid', adgroupid, 90);}
    if(adpostion.length > 0 )   {setCookie('adpostion', adpostion, 90);}             
    if(campaignid.length > 0 )  {setCookie('campaignid', campaignid, 90);}
    if(device.length > 0 )      {setCookie('device', device, 90);}
    console.log("device=" + device);
    if(devicemodel.length > 0 ) {setCookie('devicemodel', devicemodel, 90);}              
    if(keyword.length > 0 )     {setCookie('keyword', keyword, 90);}  
    if(matchtype.length > 0 )   {setCookie('matchtype', matchtype, 90);}
    if(network.length > 0 )     {setCookie('network', network, 90);}    
    if(utm_source.length > 0 )  {setCookie('utm_source', utm_source, 90);}
    if(utm_keyword.length > 0 ) {setCookie('utm_keyword', utm_keyword, 90);}
    if(utm_medium.length > 0 )  {setCookie('utm_medium', utm_medium, 90);} 
  
}
// bing
var bingmsclkid = getParam('msclkid');
if(bingmsclkid!=null && bingmsclkid.length > 0 ) {setCookie('bingmsclkid', bingmsclkid, 90);}
 
var bingutmterm = getParam('utm_term');          
if(bingutmterm!=null && bingutmterm.length > 0 ) {setCookie('bingutmterm', bingutmterm, 90);}                           
 
if (bingmsclkid!=null && bingmsclkid.length > 0 ){
  var bingsource = utm_source;                                   
  if(bingsource.length > 0 ) {setCookie('bingsource', bingsource, 90);}
}
function readCookie(name) {
  var n = name + "=";
  var cookie = document.cookie.split(';');
  for(var i=0;i < cookie.length;i++) {     
      var c = cookie[i];     
      while (c.charAt(0)==' '){c = c.substring(1,c.length);}     
      if (c.indexOf(n) == 0){return c.substring(n.length,c.length);}
  }
  return null;
}
</script>

