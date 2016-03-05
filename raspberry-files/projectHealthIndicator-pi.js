
/*
npm install cylon cylon-raspi
npm install cylon-gpio
npm install cylon-i2c
amol.muratkar@cuelogic.co.in ||
Run as - sudo node projectHealthIndicator-pi.js
*/

var Cylon = require("cylon");
var awsIot = require('aws-iot-device-sdk');

var device = awsIot.device({
  keyPath: '/home/pi/Desktop/cyclon/certs/privateKey.pem',
  certPath: '/home/pi/Desktop/cyclon/certs/cert.pem',
  caPath: '/home/pi/Desktop/cyclon/certs/rootCA.pem',
  clientId: 'rasp-pi-indicator',
  region:  'us-east-1'
});

var forCheck = '';

//
// Device is an instance returned by mqtt.Client(), see mqtt.js for full
// documentation.
//
device
  .on('connect', function() {
    console.log('connect');
    device.subscribe('project/health');
    //device.publish('project/health', JSON.stringify({ test_data: 1}));
    });

device
  .on('message', function(topic, payload) {
    console.log('message', topic, payload.toString());
	var objPayload = JSON.parse(payload);
if(objPayload.cicdtype || objPayload.healthtype) { 	
	
	Cylon.robot({
	  connections: {
	    raspi: { adaptor: 'raspi' }
	  },
	
	  devices: {
	    //led: { driver: 'led', pin: pin_no }
	    CICD_red: { driver: 'led', pin: 32 },
	    CICD_yellow: { driver: 'led', pin: 33 },
	    CICD_green: { driver: 'led', pin: 40 },
	    HEALTH_red: { driver: 'led', pin: 11 },
	    HEALTH_yellow: { driver: 'led', pin: 13 },
	    HEALTH_green: { driver: 'led', pin: 18 }
	  },
	
	  work: function(my) { 	    	 

		if(objPayload.cicdtype == 'error') {		
		my.CICD_yellow.turnOff();		
		my.CICD_green.turnOff();
		my.CICD_red.turnOn();
		}
		else if(objPayload.cicdtype == 'success') { 
		my.CICD_yellow.turnOff();		
		my.CICD_red.turnOff();
		my.CICD_green.turnOn();
		}
		else if(objPayload.cicdtype == 'warning') { 
		my.CICD_green.turnOff();
		my.CICD_red.turnOff();
		my.CICD_yellow.turnOn();		
		}
		else if(objPayload.cicdtype == 'running') { 
		my.CICD_green.turnOff();
		my.CICD_red.turnOff();
		my.CICD_yellow.turnOn();		
		}

		if(objPayload.healthtype == 'error') {		
		my.HEALTH_yellow.turnOff();		
		my.HEALTH_green.turnOff();
		my.HEALTH_red.turnOn();
		}
		else if(objPayload.healthtype == 'success') { 
		my.HEALTH_yellow.turnOff();		
		my.HEALTH_red.turnOff();
		my.HEALTH_green.turnOn();
		}
		else if(objPayload.healthtype == 'warning') { 
		my.HEALTH_green.turnOff();
		my.HEALTH_red.turnOff();
		my.HEALTH_yellow.turnOn();		
		}
		else if(objPayload.healthtype == 'running') { 
		my.HEALTH_green.turnOff();
		my.HEALTH_red.turnOff();
		my.HEALTH_yellow.turnOn();		
		}
	
		
	    console.log(456);	
	    
	    //every((1).second(), my.led.toggle);	

	  }
	}).start();
	

	
}

	
  });

/* end iot stuff */