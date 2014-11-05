@extends('layouts.default')
@section('style')
	<style>
	
	.node circle {
	  fill: #fff;
	  stroke: steelblue;
	  stroke-width: 1.5px;
	}
	
	.node {
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
	<div class="row">
		<div class="col col-md-12">
			@include('_helpers.breadcrumbs')
			<h1>Downline Visualization</h1>
		</div>
	</div>
	<div class="row">
		<div class="col col-md-12">
			<?php
				echo '<pre>'; print_r($users); echo '</pre>';
			?>
		</div>
	</div>
@stop
@section('scripts')
	<script src="http://d3js.org/d3.v3.min.js"></script>
	<script>
	
	var width = 960,
	    height = 2200;
	
	var cluster = d3.layout.cluster()
	    .size([height, width - 160]);
	
	var diagonal = d3.svg.diagonal()
	    .projection(function(d) { return [d.y, d.x]; });
	
	var svg = d3.select("body").append("svg")
	    .attr("width", width)
	    .attr("height", height)
	  .append("g")
	    .attr("transform", "translate(40,0)");
	
	d3.json("/d/4063550/flare.json", function(error, root) {
	  var nodes = cluster.nodes(root),
	      links = cluster.links(nodes);
	
	  var link = svg.selectAll(".link")
	      .data(links)
	    .enter().append("path")
	      .attr("class", "link")
	      .attr("d", diagonal);
	
	  var node = svg.selectAll(".node")
	      .data(nodes)
	    .enter().append("g")
	      .attr("class", "node")
	      .attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; })
	
	  node.append("circle")
	      .attr("r", 4.5);
	
	  node.append("text")
	      .attr("dx", function(d) { return d.children ? -8 : 8; })
	      .attr("dy", 3)
	      .style("text-anchor", function(d) { return d.children ? "end" : "start"; })
	      .text(function(d) { return d.name; });
	});
	
	d3.select(self.frameElement).style("height", height + "px");
	
	</script>
@stop
