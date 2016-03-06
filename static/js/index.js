$(function(){

    initChart();

});

function initChart() {
  
	var lineDataActual = [{
		'x': 0,
		'y': 200
	}, {
		'x': 1,
		'y': 200
	}, {
		'x': 2,
		'y': 190
	}, {
		'x': 3,
		'y': 180
	}, {
		'x': 4,
		'y': 170
	}, {
		'x': 5,
		'y': 170
	}, {
		'x': 6,
		'y': 160
	}, {
		'x': 7,
		'y': 150
	}, {
		'x': 8,
		'y': 150
	}, {
		'x': 9,
		'y': 30
	}, {
		'x': 10,
		'y': 10
	}
	];

	var svg = d3.select("#visualisation"),
		width = 1000,
		height = 500,
		margins = {
			top: 80,
			right: 50,
			bottom: 80,
			left: 80
		},
		xMin = d3.min(lineDataActual, function (d) {			
			return d.x;
		}),
		xMax = d3.max(lineDataActual, function (d) {			
			return d.x;
		}),
		yMin = d3.min(lineDataActual, function (d) {			
			return d.y;
		}),
		yMax = d3.max(lineDataActual, function (d) {			
			return d.y;
		}),

    xRange = d3.scale.linear().range([margins.left, width - margins.right]).domain([

		xMin,xMax
    ]),

	yRange = d3.scale.linear().range([height - margins.top, margins.bottom]).domain([
	
		yMin,yMax		
	]),

	xAxis = d3.svg.axis()
		.scale(xRange)
		.tickSubdivide(true),
	
	yAxis = d3.svg.axis()
		.scale(yRange)
		.orient("left")
		.tickSubdivide(true);
		
	function make_x_axis() {        
		return d3.svg.axis()
			.scale(xRange)
			 .orient("bottom")
			.tickSubdivide(true)
	}
	
	function make_y_axis() {        
		return d3.svg.axis()
			.scale(yRange)
			.orient("left")
			.tickSubdivide(true)
	}
	
	
	svg.append("g")         
        .attr("class", "grid")
        .attr("transform", "translate(0," + (height - margins.top) + ")")
        .call(make_x_axis()
            .tickSize((-height) + (margins.top + margins.bottom), 0, 0)
            .tickFormat("")
        )

    svg.append("g")         
        .attr("class", "grid")
		.attr("transform", "translate(" + (margins.left) + ",0)")
        .call(make_y_axis()
            .tickSize((-width) + (margins.right + margins.left), 0, 0)
            .tickFormat("")
        )

	svg.append("svg:g")
		.attr("class", "x axis")
		.attr("transform", "translate(0," + (height - (margins.bottom)) + ")")
		.call(xAxis);

	svg.append("svg:g")
		.attr("class", "y axis")
		.attr("transform", "translate(" + (margins.left) + ",0)")
		.call(yAxis);
		
		

	var lineFunc = d3.svg.line()
		.x(function (d) {
			return xRange(d.x);
		})
		.y(function (d) {
			return yRange(d.y);
		})
  		.interpolate('basis');
		

	var lineDataIdeal = [{
		'x': xMin,
		'y': yMax
	}, {
		'x': xMax,
		'y': yMin	
	}];


	svg.append("svg:path")
		.attr("d", lineFunc(lineDataIdeal))
		.attr("class", "ideal");
	
	svg.append("svg:path")
		.attr("d", lineFunc(lineDataActual))
		.attr("class", "actual");
	
	svg.append("linearGradient")                
        .attr("id", "line-gradient")            
        .attr("gradientUnits", "userSpaceOnUse")    
        .attr("x1", 0).attr("y1", y(0))         
        .attr("x2", 0).attr("y2", y(1000))      
    .selectAll("stop")                      
        .data([                             
            {offset: "0%", color: "red"},       
            {offset: "40%", color: "red"},  
            {offset: "40%", color: "black"},        
            {offset: "62%", color: "black"},        
            {offset: "62%", color: "lawngreen"},    
            {offset: "100%", color: "lawngreen"}    
        ])                  
    .enter().append("stop")         
        .attr("offset", function(d) { return d.offset; })   
        .attr("stop-color", function(d) { return d.color; });   
        	
	/*svg.append("text")
		.attr("class", "x label")
		.attr("text-anchor", "end")
		.attr("x", width/2)
		.attr("y", height -6)
		.text("Days");
		
	svg.append("text")
		.attr("class", "y label")
		.attr("text-anchor", "end")
		.attr("x", -200)
		.attr("dy", ".75em")
		.attr("transform", "rotate(-90)")
		.text("Hours remaining");*/
}

/*Pie Chart*/
