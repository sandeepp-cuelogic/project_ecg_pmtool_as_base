
/*
npm install aws-iot-device-sdk

nodejs jenkinsbuild.js error|warning|running|success

*/

var awsIot = require('aws-iot-device-sdk');

var device = awsIot.device({
  keyPath: '/home/sandeep/Documents/MyCompany/Projects/Hackthon/Src/project_ecg_pmtool_as_base/certs/privateKey.pem',
  certPath: '/home/sandeep/Documents/MyCompany/Projects/Hackthon/Src/project_ecg_pmtool_as_base/certs/cert.pem',
  caPath: '/home/sandeep/Documents/MyCompany/Projects/Hackthon/Src/project_ecg_pmtool_as_base/certs/rootCA.pem',
  clientId: 'jen-build-indicator',
  region:  'us-east-1'
});

var get_build_status = process.argv[2];

device
  .on('connect', function() {
    console.log('connect');
    device.subscribe('project/health');
    device.publish('project/health', JSON.stringify({ "optype": get_build_status}), function(){
    	process.exit();
    });
    //
  });
