
 <?php
 defined('BASEPATH') OR exit('No direct script access allowed');
 ?>
 
 
<!DOCTYPE HTML>
<head>
<title>Monitoring Energy Alternatif</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="<?php echo base_url('assets/css/style.css')?>" rel="stylesheet" type="text/css" media="all"/>
<link href="<?php echo base_url('assets/css/nav.css')?>" rel="stylesheet" type="text/css" media="all"/>
<link href='http://fonts.googleapis.com/css?family=Carrois+Gothic+SC' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/login.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/Chart.js')?>"></script>
 <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.easing.js')?>"></script>
 <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.ulslide.js')?>"></script>
 
 <!----Calender -------->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/clndr.css')?>" type="text/css" />
  <script src="<?php echo base_url('assets/js/underscore-min.js')?>"></script>
  <script src= "<?php echo base_url('assets/js/moment-2.2.1.js')?>"></script>
  <script src="<?php echo base_url('assets/js/clndr.js')?>"></script>
  <script src="<?php echo base_url('assets/js/site.js')?>"></script>
  <!----End Calender -------->
  <script>
		function deleteDevice()
		{
			var getSelected2 = document.getElementById('getDevice');
			var valueSelected2 = getSelected2.options[getSelected2.selectedIndex].text;
			
			
			var param2 = 'nameOfDevice='+valueSelected2;
			xhr = new XMLHttpRequest();
			xhr.open('POST' , '<?php echo site_url('/login/deleteData/'); ?>', true);
			xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
			xhr.send(param2);
			
			xhr.onreadystatechange = function()
			{
				readXHR2 = xhr.responseText; 
				//document.getElementById('message').innerHTML = readXHR2;
			}
			window.location = "http://localhost/aldy/";
		}
		window.onload = function () {

			var voltDps = []; // dataPoints
			var ampereDps = [];
			var rpmDps = [];
			
			var chart = new CanvasJS.Chart("chartContainer", {
				title :{
					text: "Data Volt, Ampere dan RPM"
				},
				axisY: {
					includeZero: false
				},      
				data: [
				{
					type: "line",
					dataPoints: voltDps
				},
				{
					type: "line",
					dataPoints: ampereDps
				},
				{
					type: "line",
					dataPoints: rpmDps
				}
				]
			});
			
			var xVal = 0;
			var yVal = 0; 
			var updateInterval = 1000;
			var dataLength = 20; // number of dataPoints visible at any point
			
			var voltSensor, ampereSensor, rpmSensor, daya;
			var getSelected, valueSelected;
			
			var updateChart = function (count) {
				
				getSelected = document.getElementById('getDevice');
				valueSelected = getSelected.options[getSelected.selectedIndex].text;
				
				var params = 'nameOfDevice='+valueSelected;
				
				xhr = new XMLHttpRequest();
				xhr.open('POST' , '<?php echo site_url('/login/autoLoad/'); ?>', true);
				xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
				xhr.send(params);
				xhr.onreadystatechange = function()
				{
					readXHR = xhr.responseText; 
					
					
					objRead = JSON.parse(readXHR); 
					voltSensor = objRead.volt;
					ampereSensor = objRead.ampere;
					rpmSensor = objRead.rpm;
					
					daya = parseFloat(voltSensor) * parseFloat(voltSensor);
				}
				
				document.getElementById('volt').innerHTML = voltSensor+" V";
				document.getElementById('ampere').innerHTML = ampereSensor+" A";
				document.getElementById('rpm').innerHTML = rpmSensor+" RPM";
				document.getElementById('daya').innerHTML = daya;
				
				count = count || 1;

				for (var j = 0; j < count; j++) {
					voltDps.push({
						x:xVal,
						y:parseFloat(voltSensor)
					});
					ampereDps.push({
						x: xVal,
						y: parseFloat(ampereSensor)
					});
					rpmDps.push({
						x: xVal,
						y: parseFloat(rpmSensor)
					});
					
					xVal++;
				}

				if (voltDps.length > dataLength) {
					voltDps.shift();
					ampereDps.shift();
					rpmDps.shift();
					
				}
				//document.getElementById('valueDatabase').innerHTML = yVal;
				chart.render();
				
				
			};

			updateChart(dataLength);
			setInterval(function(){updateChart()}, updateInterval);

		}
	
	</script>
	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
	<style>
	select#getDevice, select#getDevice-color {
	   -webkit-appearance: button;
	   -webkit-border-radius: 2px;
	   -webkit-box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1);
	   -webkit-padding-end: 20px;
	   -webkit-padding-start: 2px;
	   -webkit-user-select: none;
	   background-image: url(http://i62.tinypic.com/15xvbd5.png), -webkit-linear-gradient(#FAFAFA, #F4F4F4 40%, #E5E5E5);
	   background-position: 97% center;
	   background-repeat: no-repeat;
	   border: 1px solid #AAA;
	   color: #555;
	   font-size: inherit;
	   margin: 20px;
	   overflow: hidden;
	   padding: 5px 10px;
	   text-overflow: ellipsis;
	   white-space: nowrap;
	   width: 300px;
	}

	select#getDevice-color {
	   color: #fff;
	   background-image: url(http://i62.tinypic.com/15xvbd5.png), -webkit-linear-gradient(#779126, #779126 40%, #779126);
	   background-color: #779126;
	   -webkit-border-radius: 20px;
	   -moz-border-radius: 20px;
	   border-radius: 20px;
	   padding-left: 15px;
	}

	</style>
	
</head>
<body>	
<div id="message"></div>		       
	    <div class="wrap">	 
	      <div class="header">
	      	  <div class="header_top">
					  <div class="menu">
						  <a class="toggleMenu" href="#"><img src="<?php echo base_url('assets/images/nav.png')?>" alt="" /></a>
							<ul class="nav">
								<select id="getDevice">
									<?php foreach($posts as $post){?>
										<option ><?php echo $post->nama;?></option>
									<?php }?> 
								  
								</select>
							<div class="clear"></div>
						    </ul>
							<script type="text/javascript" src="<?php echo base_url('assets/js/responsive-nav.js')?>"></script>
				        </div>	
					  <div class="profile_details">
				    		   <div id="loginContainer">
				                  <a id="loginButton" class=""><span>Me</span></a>   
				                    <div id="loginBox">                
				                      <form id="loginForm">
				                        <fieldset id="body">
				                            <div class="user-info">
							        			<h4>Hello,<a href="#"> Username</a></h4>
							        			<ul>
							        				<li class="profile active"><a href="#">Profile </a></li>
							        				<li class="logout"><a href="#"> Logout</a></li>
							        				<div class="clear"></div>		
							        			</ul>
							        		</div>			                            
				                        </fieldset>
				                    </form>
				                </div>
				            </div>
				             <div class="profile_img">	
				             	<a href="#"><img src="<?php echo base_url('assets/images/cambodia.png')?>" alt="" />	</a>
				             </div>		
				             <div class="clear"></div>		  	
					    </div>	
		 		      <div class="clear"></div>				 
				   </div>
			</div>	  					     
	</div>
	  <div class="main">  
	    <div class="wrap">  		 
	        
	  		<div class="column_left">	     
		             <div class="graph">
						
		             	<div class="graph_list" >
							
		             		 <div class="week-month-year">
		             		 	
		             		 	<p><a href="#" id="deleteDevice" onClick="deleteDevice()" class="active">Delete Current Device</a></p>
		             		 	
		             		 	<div class="clear"></div>
		             		 </div>
				      			
				      </div>
		             </div>
					 <div id="chartContainer" style="height: 200px; width: 100%;"></div>
		          
	  		</div>
            <div class="column_middle">
              <div class="column_middle_grid1">
		           <div class="articles_list">
		           	  <ul>
		           	  	<li><a href="#" class="red"> <img src="<?php echo base_url('assets/images/lightning.png')?>" alt="" /> <i id="volt">23</i></a></li>
		           	  	<li><a href="#" class="purple"> <img src="<?php echo base_url('assets/images/voltage.png')?>" alt="" /> <i id="ampere">24</i></a></li>
		           	  	<li><a href="#" class="yellow"> <img src="<?php echo base_url('assets/images/speedometer.png')?>" alt="" /> <i id="rpm">49</i></a></li>
		           	  	<div class="clear"></div>	
		           	  </ul>
		           </div>
		       </div>
		         <div class="weather">
		               <h3><i><img src="<?php echo base_url('assets/images/location.png')?>" alt="" /> </i> Malang Indonesia</h3>
		              <div class="today_temp">
		                <div class="temp">
							<figure>Daya<span><i id="daya">24</i><em>Watt</em></span></figure>
						</div>
						
					</div>
						
		          </div>	           
		      
    	    </div>
			
		
            <div class="column_right">
            	
				    <div class="column_right_grid sign-in">
				 	<div class="sign_in">
				       <h3>Add Device</h3>
					    <?php echo form_open('login');?>
					    	
					 	    <span>
					 	     <i><img src="<?php echo base_url('assets/images/user.png')?>" alt="" /></i>
					 	     <input type="text" name="namaDevice" placeholder="Nama Device">
					 	    </span>
					 		<input type="submit" class="my-button" name="addDevice" value="Add Device">
					 	<?php echo form_close();?>
					       			   
          		       </div>
          		 	  
				   </div>
				   
				   
             </div>
			 
    	<div class="clear"></div>
 	 </div>
   </div>
  		 <div class="copy-right">
				<p>© 2019 Designed by <a href="http://yhoora.tech/" target="_blank">yhoora.tech</a>  </p>
	 	 </div> 
		 
</body>
 <script src="<?php echo base_url('assets/js/lib/chart-js/Chart.bundle.js')?>"></script>
    <script src="<?php echo base_url('assets/js/lib/vector-map/jquery.vmap.js')?>"></script>
    <script src="<?php echo base_url('assets/js/lib/vector-map/jquery.vmap.min.js')?>"></script>
    <script src="<?php echo base_url('assets/js/lib/vector-map/jquery.vmap.sampledata.js')?>"></script>
    <script src="<?php echo base_url('assets/js/lib/vector-map/country/jquery.vmap.world.js')?>"></script>
</html>

