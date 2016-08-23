<?php
/**
 * This is default whois servers array
 * key as the extension exists
 * and values as server ([1]) and match words ([2])
 *
 * To adding sub domain , just use the whois servers and match for subdomain keys array
 *
 * @link http://www.iana.org/domains/root/db to found whois server root database from iana registrars
 * @license { @link http://codecanyon.net/licenses }
 * @param array $whoisservers
 * @revision october 2nd 2014
 * 		- fix .nu match
 */
$whoisservers = array(
# // A
'.ac'    => array('whois.nic.ac','is available for purchase'),
'.ae'    => array('whois.aeda.net.ae','No Data Found'),
'.aero'  => array('whois.aero','NOT FOUND'),
'.af'    => array('whois.nic.af','No Object Found'),
'.ag'    => array('whois.nic.ag','NOT FOUND'),
'.am'    => array('whois.nic.am','No match'),
'.archi' => array('whois.ksregistry.net','not found'),
'.as'    => array('whois.nic.as','Domain Status: Available'),
'.au'    => array('whois.aunic.net','No Data Found'),
'.asia'  => array('whois.nic.asia','NOT FOUND'),
'.at'    => array('whois.nic.at','nothing found'),
'.axa'   => array('whois.nic.axa','Not Found'),
# // B
'.bar'   => array('whois.nic.bar','NOT FOUND'),
'.be'    => array('whois.dns.be','Status:AVAILABLE'),
'.berlin'=> array('whois.nic.berlin','No match'),
'.best'  => array('whois.nic.best','Not Found'),
'.bg'    => array('whois.register.bg','does not exist'),
'.bi'    => array('whois1.nic.bi','No Object Found'),
'.bid'   => array('whois.nic.bid','Not found'),
'.biz'   => array('whois.nic.biz','Not found'),
'.bj'    => array('whois.nic.bj','No records'),
'.black' => array('whois.nic.black','NOT FOUND'),
'.blackfriday' => array('whois.uniregistry.net','is available for registration'),
'.blue'  => array('whois.nic.blue','NOT FOUND'),
'.bo'    => array('whois.nic.bo','solo acepta consultas'),
'.br'    => array('whois.nic.br','No match for'),
'.build' => array('whois.nic.build','No Data Found'),
'.buzz'  => array('whois.nic.buzz','Not found'),
'.bw'    => array('whois.nic.net.bw','No Object Found'),
'.by'    => array('whois.cctld.by','Object does not exist'),
'.bz'    => array('whois.afilias-grs.info','NOT FOUND'),
# // C
'.ca'    => array('whois.cira.ca','Domain status:         available'),
'.cat'   => array('whois.cat','NOT FOUND'),
'.cc'    => array('whois.nic.cc','No match'),
'.cd'    => array('whois.nic.cd','Domain Status: Available'),
'.ceo'   => array('whois.nic.ceo','Not found'),
'.cf'    => array('whois.dot.cf','domain name not known'),
'.co'    => array('whois.nic.co','Not found'),
'.com'   => array('whois.crsnic.net','No match for'),
'.ch'    => array('whois.nic.ch','not have an entry'),
'.christmas'=> array('whois.nic.christmas','is available for registration'),
'.ci'    => array('whois.nic.ci','not found'),
'.ck'    => array('whois.nic.ck','No entries found'),
'.cl'    => array('whois.nic.cl','no existe'),
'.cn'    => array('whois.cnnic.net.cn','no matching record'),
'.college'=> array('whois.centralnic.com','DOMAIN NOT FOUND'),
'.cologne'=> array('whois.nic.cologne','no matching objects found'),
'.cooking'=> array('whois.nic.cooking','Status: Not Registered'),
'.country'=> array('whois.nic.country','Status: Not Registered'),
'.coop'  => array('whois.nic.coop','No domain records'),
'.cx'    => array('whois.nic.cx','No Object Found'),
'.cz'    => array('whois.nic.cz','No entries found'),
# // D
'.dance' => array('whois.nic.dance','Domain not found'), # ambigu
'.democrat'=> array('whois.nic.democrat','Domain not found'), # ambigu
'.de'    => array('whois.denic.de','free'),
'.desi'  => array('whois.nic.desi','not found'),
'.dk'    => array('whois.dk-hostmaster.dk','No entries found'),
'.dm'    => array('whois.nic.cx','No entries found'),
'.dz'    => array('whois.nic.dz','NO OBJECT FOUND!'),
# // E
'.edu'   => array('whois.educause.edu','No Match'),
'.ee'    => array('whois.eenet.ee','No entries found'),
// '.es'    => array('whois.nic.es','No entries found'), #for .es domain you must be confirm premitted access to red.es , please refer http://red.es
'.eu'    => array('whois.eu','Status:AVAILABLE'),
'.eus'   => array('whois.nic.eus','no matching objects found'),
# // F
'.feedback'=> array('whois.nic.feedback','DOMAIN NOT FOUND'),
'.fi'    => array('whois.ficora.fi','Domain not found'),
'.fishing'=> array('whois-dub.mm-registry.com','Not Registered'),
'.fm'    => array('whois.nic.fm','Status: Not Registered'),
'.fo'    => array('whois.nic.fo','No entries found'),
'.foo'   => array('whois.nic.foo','Domain not found'),
'.fr'    => array('whois.nic.fr','No entries found'),
'.frogans'=> array('whois.nic.frogans','Domain cannot be found'),
'.futbol'=> array('whois.nic.futbol','Domain not found'),
# // G
'.gd'    => array('whois.nic.gd','not found'),
'.gg'    => array('whois.channelisles.net','Status: Not Registered'),
'.gi'    => array('whois2.afilias-grs.net','NOT FOUND'),
'.gift'  => array('whois.nic.gift','is available for registration'),
'.gl'    => array('whois.nic.gl','No Object Found'),
'.gop'   => array('whois.nic.gop','Status: Not Registered'),
'.gov'   => array('whois.nic.gov','No match for'),
'.gs'    => array('whois.nic.gs','No Object Found'),
'.gy'    => array('whois.registry.gy','No Object Found'),
# // H
'.hk'    => array('whois.hkirc.hk','has not been registered'),
'.hm'    => array('whois.registry.hm','Domain not found'),
'.hn'    => array('whois.nic.hn','No Object Found'),
'.hr'    => array('whois.dns.hr','No entries found'),
'.hu'    => array('whois.nic.hu','No match'),
# // I
'.info'  => array('whois.afilias.info','NOT FOUND'),
'.ie'    => array('whois.domainregistry.ie','% Not Registered'),
'.im'    => array('whois.nic.im','was not found'),
'.in'    => array('whois.inregistry.in','NOT FOUND'),
'.io'    => array('whois.nic.io','is available for purchase'),
'.is'    => array('whois.isnic.is','No entries found'),
'.it'    => array('whois.nic.it','Status:             AVAILABLE'),
# //J
'.jp'    => array('whois.jprs.jp','No match!!'),
'.je'    => array('whois.je','Domain Status: Available'),
'.jetzt' => array('whois.nic.jetzt','Not found:'),
# // K
'.kaufen'=> array('whois.nic.kaufen','Domain not found'),
'.ke'    => array('whois.kenic.or.ke','Status: Not Registered'),
'.kg'    => array('whois.domain.kg','This domain is available for registration'),
'.ki'    => array('whois.nic.ki','No Object Found'),
'.kim'   => array('whois.nic.kim','NOT FOUND'),
'.kiwi'  => array('whois.nic.kiwi','Status: Not Registered'),
'.koeln' => array('whois.nic.koeln','no matching objects found'),
'.kr'    => array('whois.kr','domain name is not registered'),
'.kred'  => array('whois.nic.kred','Not found'),
'.kz'    => array('whois.nic.or.kr','Nothing found'),
# // L
'.la'    => array('whois.nic.la','DOMAIN NOT FOUND'),
'.lc'    => array('whois.nic.lc','NOT FOUND'),
'.li'    => array('whois.nic.li','do not have an entry in our database matching your query'),
'.link'  => array('whois.nic.link','is available for registration'),
'.lk'    => array('whois.nic.lk','Domain is not available'),
'.london'=> array('whois.nic.london','Status: Not Registered'),
'.lt'    => array('whois.domreg.lt','Status:			available'),
'.lu'    => array('whois.dns.lu','No such domain'),
'.luxury'=> array('whois.nic.luxury','No Data Found'),
'.lv'    => array('whois.nic.lv','Status: free'),
'.ly'    => array('whois.nic.ly','Not found'),
# // M
'.ma'    => array('whois.iam.net.ma ','No Objects Found'),
'.mango' => array('whois.nic.mango ','no matching objects found'),
'.mc'    => array('whois.nic.mc ','no matching objects found'),
'.md'    => array('whois.nic.md','No match for'),
'.me'    => array('whois.nic.me','NOT FOUND'),
'.meet'  => array('whois.nic.meet','NOT FOUND'),
'.menu'  => array('whois.nic.menu','No Data Found'),
'.mg'    => array('whois.nic.mg','Domain Status: Available'),
'.miami' => array('whois.nic.miami','Status: Not Registered'),
'.mk'    => array('whois.marnet.mk','No entries found'),
'.ml'    => array('whois.dot.ml','domain name not known'),
'.mo'    => array('whois.monic.mo','No match for'),
'.moda'  => array('whois.nic.moda','Domain not found'),
'.moe'   => array('whois.nic.moe','Not found'),
'.monash'=> array('whois.nic.monash','No Data Found'),
'.mobi'  => array('whois.dotmobiregistry.net','NOT FOUND'),
'.ms'    => array('whois.nic.ms','Domain Status: No Object Found'),
'.mx'    => array('whois.nic.mx','No_Se_Encontro_El_Objeto/Object_Not_Found'),
'.my'    => array('whois.mynic.net.my','does not exist in database'),
# // N
'.net'   => array('whois.crsnic.net','No match for'),
'.nl'    => array('whois.domain-registry.nl','is free'),
'.no'    => array('finger.norid.no:79','is available'),
'.nu'    => array('whois.nic.nu','nu" not found'),
# // O
'.org'   => array('whois.pir.org','NOT FOUND'),
# // P
'.pl'    => array('whois.dns.pl','No information available'),
'.pm'    => array('whois.nic.pm','No entries found'),
'.pro'   => array('whois.registrypro.pro','NOT FOUND'),
'.pt'    => array('whois.dns.pt','no match'),
'.pub'   => array('whois.nic.pub','Domain not found'),
'.pw'    => array('whois.nic.pw','DOMAIN NOT FOUND'),
# // Q
'.qa'    => array('whois.registry.qa','No Data Found'),
# // R
'.re'    => array('whois.nic.re','No entries found'),
'.ro'    => array('whois.rotld.ro','No entries found'),
# // S
'.sc'    => array('whois2.afilias-grs.net','NOT FOUND'),
'.se'    => array('whois.nic-se.se','not found'),
'.sg'    => array('whois.nic.net.sg','NOT FOUND'),
'.sh'    => array('whois.nic.sh','No match'),
'.si'    => array('whois.arnes.si','No entries found'),
'.sk'    => array('whois.sk-nic.sk','Not found'),
'.sm'    => array('whois.nic.sm','No entries found'),
'.st'    => array('whois.nic.st','No entries found'),
'.su'    => array('whois.tcinet.ru','No entries found'),
# // T
'.tc'    => array('whois.adamsnames.tc','is not registered'),
'.tel'   => array('whois.nic.tel','Not found'),
'.tf'    => array('whois.nic.tf','No entries found'),
'.th'    => array('whois.thnic.co.th','is not registered'),
'.tk'    => array('whois.dot.tk','Invalid query'),
'.tl'    => array('whois.nic.tl','Available'),
'.tm'    => array('whois.nic.tm','No match'),
'.tn'    => array('whois.ati.tn','not found'),
'.to'    => array('whois.tonic.to','No match for'),
'.travel'=> array('whois.nic.travel','Not found'),
'.tv'    => array('whois.nic.tv','No match for'),
'.tw'    => array('whois.twnic.net.tw','No Found'),
# // U
'.ua'    => array('whois.net.ua','No entries found'),
'.ug'    => array('whois.co.ug','No entries found'),
'.uk'    => array('whois.nic.uk','No match'),
'.us'    => array('whois.nic.us','Not found'),
'.uy'    => array('whois.nic.org.uy','No match for'),
'.uz'    => array('whois.cctld.uz','not found in database'),
'.to'    => array('monarch.tonic.to','No match for'),
# // V
'.vc'    => array('whois.adamsnames.tc','is not registered'),
'.ve'    => array('whois.nic.ve','is not registered'),
'.vg'    => array('whois.adamsnames.tc','is not registered'),
'.vn'    => array('http://www.whois.net.vn/whois.php?act=getwhois&domain=', 'Ten mien nay chua'), # method use curl
# // W
'.wf'    => array('whois.nic.wf','No entries found'),
'.ws'    => array('whois.nic.ws','No match for'),
# // X
'.xxx'   => array('whois.nic.xxx','NOT FOUND'),
# // Y
'.yt'    => array('whois.nic.yt','No entries found'),
// '.mil'   => array('whois.internic.net','No match for'),

# cctld domain .id
'.co.id'  => array('whois.paneldotid.com','NOT FOUND '),
'.or.id'  => array('whois.paneldotid.com','NOT FOUND '),
'.net.id' => array('whois.paneldotid.com','NOT FOUND '),
'.ac.id'  => array('whois.paneldotid.com','NOT FOUND '),
'.sch.id' => array('whois.paneldotid.com','NOT FOUND '),
'.web.id' => array('whois.paneldotid.com','NOT FOUND '),
'.mil.id' => array('whois.paneldotid.com','NOT FOUND '),
'.go.id'  => array('whois.paneldotid.com','NOT FOUND '),
'.my.id'  => array('whois.paneldotid.com','NOT FOUND '),

# cctld domain uk

'.co.uk'  => array('whois.nic.uk','No match'),
'.net.uk' => array('whois.nic.uk','No match'),
'.org.uk' => array('whois.nic.uk','No match'),
'.ltd.uk' => array('whois.nic.uk','No match'),
'.plc.uk' => array('whois.nic.uk','No match'),
'.me.uk'  => array('whois.nic.uk','No match'),

# cctld domain .vn
'.ac.vn'     => array('http://www.whois.net.vn/whois.php?act=getwhois&domain=', 'Ten mien nay chua'),
'.biz.vn'    => array('http://www.whois.net.vn/whois.php?act=getwhois&domain=', 'Ten mien nay chua'),
'.edu.vn'    => array('http://www.whois.net.vn/whois.php?act=getwhois&domain=', 'Ten mien nay chua'),
'.gov.vn'    => array('http://www.whois.net.vn/whois.php?act=getwhois&domain=', 'Ten mien nay chua'),
'.health.vn' => array('http://www.whois.net.vn/whois.php?act=getwhois&domain=', 'Ten mien nay chua'),
'.info.vn'   => array('http://www.whois.net.vn/whois.php?act=getwhois&domain=', 'Ten mien nay chua'),
'.int.vn'    => array('http://www.whois.net.vn/whois.php?act=getwhois&domain=', 'Ten mien nay chua'),
'.name.vn'   => array('http://www.whois.net.vn/whois.php?act=getwhois&domain=', 'Ten mien nay chua'),
'.net.vn'    => array('http://www.whois.net.vn/whois.php?act=getwhois&domain=', 'Ten mien nay chua'),
'.org.vn'    => array('http://www.whois.net.vn/whois.php?act=getwhois&domain=', 'Ten mien nay chua'),
'.pro.vn'    => array('http://www.whois.net.vn/whois.php?act=getwhois&domain=', 'Ten mien nay chua'),
);
