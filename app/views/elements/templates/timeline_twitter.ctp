<script type="text/template" id="tweetRow">
	<div class="twitterNews">
		<div class="icon">
			<%
				if (jQuery.trim(profile_img) != "") {
			%>
					<img alt="<%= username %>" src="<%= profile_img %>" width=50 />
			<%
				}else {
			%>
					<p><%= username %></p>
			<%
				}
			%>
		</div>
		<div class="tContent">
			<h4 class="section grey">
				<span style='font-weight: 700'><%= username %></span> - <span style='font-weight: 400'><%= category_name %></span>
			</h4>
			<div class="photo">
			</div>
			<p class="summary">
				<%=
					text.replace(/(http(s)?:\/\/([-\w\.]+)+(:\d+)?(\/([\w/_\.]*(\?\S+)?)?)?)/g, '<a href="$1" target="_blank">$1</a>')
				%>
			</p>
		</div>
	
		<div class="mainComments">
			<span class="green right bottom">
			<br />
			
				
			</span>
			<br />
			<br />
			<br />
		</div>
	
		<br clear="both"/>
	</div>
</script>