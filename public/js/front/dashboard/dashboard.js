var basePath = $('meta[name="base-path"]').attr('content');

$(document).ready(function()
{
	var action = basePath+'/dashboard/buildAllInOneChart';

	$.ajax(
	{
	  	type: 'GET',
	  	url: action,
	  	processData: false,
	  	contentType: false,
	  	success: function(data)
	  	{
	  		if (data.graph == 'pie') 
	  		{
	  			createAllInOnePie(data.dataset);
	  		}	
	  	},
	  	error: function (data)
	  	{
	  		console.log(data);
	  	}
	}); 
})

function buildCourseWiseCharts(element)
{
	var $this = $(element);
	var course 	= $this.val();
	
	var formData = new FormData();
	formData.append('course_id', course);

	var action = basePath+'/dashboard/buildCourseWiseCharts';

	$.ajax(
	{
	  	type: 'POST',
	  	url: action,
	  	data: formData,
	  	processData: false,
	  	contentType: false,
	  	success: function(data)
	  	{
	  		if (data.graph == 'pie') 
	  		{
	  			createCourseWisePie(data.dataset, data.tooltip );
	  		}	
	  	},
	  	error: function (data)
	  	{
	  		console.log(data);
	  	}
	}); 
}

function createCourseWisePie(dataset, tooltipData)
{
	$('#CourseWiseChart').html('');

	var width = 360;
    var height = 360;
    var radius = Math.min(width, height) / 2;

    var color = d3.scaleOrdinal()
    		.range(["#27ae60", "#e74c3c"]);
   

    // lagend and react
    var legendRectSize = 18;
	var legendSpacing = 4;

    // for donut chart
    var donutWidth = radius * 1.0;


    var svg = d3.select('#CourseWiseChart')
	  	.append('svg')
	  	.attr('width', width)
	  	.attr('height', height)
	  	.append('g')
	  	.attr('transform', 'translate(' + (width / 2) +
	    ',' + (height / 2) + ')');


	var arc = d3.arc()
         .outerRadius(donutWidth)
    	 .innerRadius(radius * 0.4);

    var pie = d3.pie()
      .value(function(d) { return d.count; })
      .sort(null);


     var tooltip = d3.select('#CourseWiseChart')                               
      				.append('div')                                                
      				.attr('class', 'tooltip');                                    
    	
    	tooltip.append('div')                                           
      			.attr('class', 'total_questions');                                      
    	
    	tooltip.append('div')                                           
      			.attr('class', 'total_attemted');                                      
    	
    	tooltip.append('div')                                           
      			.attr('class', 'total_right');

      	tooltip.append('div')                                           
      			.attr('class', 'total_wrong');   

		tooltip.append('div')                                           
      			.attr('class', 'status');                                    

   	var path = svg.selectAll('path')
      	.data(pie(dataset))
      	.enter()
      	.append('path')
      	.attr('d', arc)
      	.attr('fill', function(d) 
      	{
        	return color(d.data.label);
  		});

 	path.on('mouseover', function(d) 
 	{                            
        var total_questions = tooltipData.total_questions;                                          
        var total_attemted 	= tooltipData.total_attemted;
        var total_right 	= tooltipData.total_right;
        var total_wrong 	= tooltipData.total_wrong;
        var exam_status 	= tooltipData.exam_status;

        tooltip.select('.total_questions').html(total_questions);                
        tooltip.select('.total_attemted').html(total_attemted);                
        tooltip.select('.total_right').html(total_right);             
        tooltip.select('.total_wrong').html(total_wrong);             
        tooltip.select('.status').html(exam_status);  
                   
        tooltip.style('display', 'block');                          
  	});                                                           

  	path.on('mouseout', function() 
  	{                              
        tooltip.style('display', 'none');                           
  	});  

  	var legend = svg.selectAll('.legend')
	    .data(color.domain())
	    .enter()
	    .append('g')
	    .attr('class', 'legend')
	    .attr('transform', function(d, i) {
	      var height = legendRectSize + legendSpacing;
	      var offset =  height * color.domain().length / 2;
	      var horz = -2 * legendRectSize;
	      var vert = i * height - offset;
	      return 'translate(' + horz + ',' + vert + ')';
	    });

	  legend.append('rect')
	    .attr('width', legendRectSize)
	    .attr('height', legendRectSize)
	    .style('fill', color)
	    .style('stroke', color);

	  legend.append('text')
	    .attr('x', legendRectSize + legendSpacing)
	    .attr('y', legendRectSize - legendSpacing)
	    .text(function(d) { return d; });
}

function createAllInOnePie(dataset, tooltipData)
{
	$('#AllInOneChart').html('');

	var width = 360;
    var height = 360;
    var radius = Math.min(width, height) / 2;

    var color = d3.scaleOrdinal()
    		.range(["#27ae60", "#e74c3c"]);
   

    // lagend and react
    var legendRectSize = 18;
	var legendSpacing = 4;

    // for donut chart
    var donutWidth = radius * 1.0;


    var svg = d3.select('#AllInOneChart')
	  	.append('svg')
	  	.attr('width', width)
	  	.attr('height', height)
	  	.append('g')
	  	.attr('transform', 'translate(' + (width / 2) +
	    ',' + (height / 2) + ')');


	var arc = d3.arc()
         .outerRadius(donutWidth)
    	 .innerRadius(radius * 0.4);

    var pie = d3.pie()
      .value(function(d) { return d.count; })
      .sort(null);


    var tooltip = d3.select('#AllInOneChart')                               
      				.append('div')                                                
      				.attr('class', 'tooltip');                                                                       

   	var path = svg.selectAll('path')
      	.data(pie(dataset))
      	.enter()
      	.append('path')
      	.attr('d', arc)
      	.attr('fill', function(d) 
      	{
        	return color(d.data.label);
  		});

 	// path.on('mouseover', function(d) 
 	// {                            
  //       var total_questions = tooltipData.total_questions;                                          
  //       var total_attemted 	= tooltipData.total_attemted;
  //       var total_right 	= tooltipData.total_right;
  //       var total_wrong 	= tooltipData.total_wrong;
  //       var exam_status 	= tooltipData.exam_status;

  //       tooltip.select('.total_questions').html(total_questions);                
  //       tooltip.select('.total_attemted').html(total_attemted);                
  //       tooltip.select('.total_right').html(total_right);             
  //       tooltip.select('.total_wrong').html(total_wrong);             
  //       tooltip.select('.status').html(exam_status);  
                   
  //       tooltip.style('display', 'block');                          
  // 	});                                                           

  // 	path.on('mouseout', function() 
  // 	{                              
  //       tooltip.style('display', 'none');                           
  // 	});  

  	var legend = svg.selectAll('.legend')
	    .data(color.domain())
	    .enter()
	    .append('g')
	    .attr('class', 'legend')
	    .attr('transform', function(d, i) {
	      var height = legendRectSize + legendSpacing;
	      var offset =  height * color.domain().length / 2;
	      var horz = -2 * legendRectSize;
	      var vert = i * height - offset;
	      return 'translate(' + horz + ',' + vert + ')';
	    });

	  legend.append('rect')
	    .attr('width', legendRectSize)
	    .attr('height', legendRectSize)
	    .style('fill', color)
	    .style('stroke', color);

	  legend.append('text')
	    .attr('x', legendRectSize + legendSpacing)
	    .attr('y', legendRectSize - legendSpacing)
	    .text(function(d) { return d; });
}