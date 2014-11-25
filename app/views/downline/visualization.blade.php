@extends('layouts.default')
@section('style')
	<style>
	
	#dendrogram-header { margin:30px 0 0 30px !important; }
	#content { position:relative; }
	#dendrogram-container { position:absolute; top:0; right:0; bottom:0; left:0; }
	#dendrogram { position:absolute; top:0; right:0; bottom:0; left:0; overflow:auto !important; height:100%; }
	hr, footer { display:none; }
	
	svg { width:2000px; height:750px; overflow:auto !important; }
	
	.node {
	  cursor: pointer;
	}
	
	.node circle {
	  fill: #fff;
	  stroke: steelblue;
	  stroke-width: 1.5px;
	}
	
	.node text {
	  font: 10px sans-serif;
	}
	
	.link {
	  fill: none;
	  stroke: #ccc;
	  stroke-width: 1.5px;
	}
	
	</style>
@stop
@section('content')
	<div id="dendrogram-container">
		<div id="dendrogram">
			<div id="dendrogram-header">
				@include('_helpers.breadcrumbs')
				<h1>Downline Visualization</h1>
			</div>
		</div>
	</div>
@stop
@section('scripts')
	<script src="//d3js.org/d3.v3.min.js"></script>
	<script>
	
		var margin = {top: 20, right: 120, bottom: 20, left: 120},
		    width = 2000 - margin.right - margin.left,
		    height = 750 - margin.top - margin.bottom;
		    
		var i = 0,
		    duration = 750,
		    root;
		
		var tree = d3.layout.tree()
		    .size([height, width]);
		
		var diagonal = d3.svg.diagonal()
		    .projection(function(d) { return [d.y, d.x]; });
		
		var svg = d3.select("#dendrogram").append("svg")
		    .attr("width", width + margin.right + margin.left)
		    .attr("height", height + margin.top + margin.bottom)
		  .append("g")
		    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
		
		d3.json("/api/all-branches", function(error, flare) {
		  root = flare;
		  root.x0 = height / 2;
		  root.y0 = 0;
		
		  function collapse(d) {
		    if (d.children) {
		      d._children = d.children;
		      d._children.forEach(collapse);
		      d.children = null;
		    }
		  }
		
		  root.children.forEach(collapse);
		  update(root);
		});
		
		d3.select(self.frameElement).style("height", "800px");
		
		function update(source) {
		
		  // Compute the new tree layout.
		  var nodes = tree.nodes(root).reverse(),
		      links = tree.links(nodes);
		
		  // Normalize for fixed-depth.
		  nodes.forEach(function(d) { d.y = d.depth * 180; });
		
		  // Update the nodes…
		  var node = svg.selectAll("g.node")
		      .data(nodes, function(d) { return d.id || (d.id = ++i); });
		
		  // Enter any new nodes at the parent's previous position.
		  var nodeEnter = node.enter().append("g")
		      .attr("class", "node")
		      .attr("transform", function(d) { return "translate(" + source.y0 + "," + source.x0 + ")"; })
		      .on("click", click);
		
		  nodeEnter.append("circle")
		      .attr("r", 1e-6)
		      .style("fill", function(d) { return d._children ? "lightsteelblue" : "#fff"; });
		
		  nodeEnter.append("text")
		      .attr("x", function(d) { return d.children || d._children ? -10 : 10; })
		      .attr("dy", ".35em")
		      .attr("text-anchor", function(d) { return d.children || d._children ? "end" : "start"; })
		      .text(function(d) { return d.name; })
		      .style("fill-opacity", 1e-6);
		      
		nodeEnter.append('id').text(function(d) {
			return d.id;
		});
		
		nodeEnter.append('rank').text(function(d) {
			return d.rank;
		});
		
		nodeEnter.append('phone').text(function(d) {
			return d.phone;
		});
		
		nodeEnter.append('email').text(function(d) {
			return d.email;
		});
		
		// close popovers upon animation
		$('.downline-popover').remove();
		
		  // Transition nodes to their new position.
		  var nodeUpdate = node.transition()
		      .duration(duration)
		      .attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; });
		
		  nodeUpdate.select("circle")
		      .attr("r", 4.5)
		      .style("fill", function(d) { return d._children ? "lightsteelblue" : "#fff"; });
		
		  nodeUpdate.select("text")
		      .style("fill-opacity", 1);
		
		  // Transition exiting nodes to the parent's new position.
		  var nodeExit = node.exit().transition()
		      .duration(duration)
		      .attr("transform", function(d) { return "translate(" + source.y + "," + source.x + ")"; })
		      .remove();
		
		  nodeExit.select("circle")
		      .attr("r", 1e-6);
		
		  nodeExit.select("text")
		      .style("fill-opacity", 0);
		
		  // Update the links…
		  var link = svg.selectAll("path.link")
		      .data(links, function(d) { return d.target.id; });
		
		  // Enter any new links at the parent's previous position.
		  link.enter().insert("path", "g")
		      .attr("class", "link")
		      .attr("d", function(d) {
		        var o = {x: source.x0, y: source.y0};
		        return diagonal({source: o, target: o});
		      });
		
		  // Transition links to their new position.
		  link.transition()
		      .duration(duration)
		      .attr("d", diagonal);
		
		  // Transition exiting nodes to the parent's new position.
		  link.exit().transition()
		      .duration(duration)
		      .attr("d", function(d) {
		        var o = {x: source.x, y: source.y};
		        return diagonal({source: o, target: o});
		      })
		      .remove();
		
		  // Stash the old positions for transition.
		  nodes.forEach(function(d) {
		    d.x0 = d.x;
		    d.y0 = d.y;
		  });
		}
		
		// Toggle children on click.
		function click(d) {
		  if (d.children) {
		    d._children = d.children;
		    d.children = null;
		  } else {
		    d.children = d._children;
		    d._children = null;
		  }
		  update(d);
		}
	
		// open popovers
		$('g').on({
			mouseenter: function(event) {
				$('.downline-popover').remove();
				var id = $(this).siblings('id').text();
				var rank = $(this).siblings('rank').text();
				var phone = $(this).siblings('phone').text();
				var email = $(this).siblings('email').text();
				mouseX = event.pageX - 120;
				mouseY = event.pageY - 115;
		        // currentMousePos.y = event.pageY;
				$('body').prepend(
					'<div class="popover downline-popover fade top in" role="tooltip" style="top:' + mouseY + 'px; left:' + mouseX + 'px">' +
						'<div style="left: 50%;" class="arrow"></div><div class="popover-content">' +
							'<table>' +
								'<tr><th>ISM ID:</th><td>' + id + '@if (Auth::user()->hasRole(["Superadmin", "Admin"]))<a style="pull-right" href="/users/' + id + '"><i class="fa fa-eye"></i></a>@endif<td></tr>' +
								'<tr><th>Rank:</th><td>' + rank + '</td></tr>' +
								'<tr><th>Phone:</th><td>' + phone + '</td></tr>' +
								'<tr><th>Email:</th><td><form method="post" action="/users/email"><input type="hidden" name="user_ids[]" value="' + id + '"><button class="nostyle"><span class="link">' + email + '</span></button></form></td></tr>' +
							'</table>' +
						'</div>' +
					'</div>'
				);
			}
		}, ' text')
		
		// close popovers
		$('g').on({
			mouseout: function() {
				timer = setTimeout(function() {
					$('.downline-popover').remove();
				}, 1000);
			}
		}, ' text');
		$('body').on({
			mouseenter: function() {
				clearTimeout(timer);
			}
		}, '.downline-popover');
	
	</script>
	<style>
		
		.downline-popover { display:block; }
		
	</style>
@stop