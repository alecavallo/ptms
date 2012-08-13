<script type="text/template" id="usrRow">
<div class="usrRow">
	<div class="uAvatar">
		<img alt="<%=User.alias%>" src="<%= User.avatar %>"/>
	</div>
	<div class="section grey">
		<%
			if (typeof User.alias != "undefined") {
		%>
				<a href="/columna/<%=User.alias%>.html"><span class="name"><%=User.first_name%> <%=User.last_name%></span> - <span class="nick"><%=User.alias%></span></a>
		<%
			}else{
		%>
				<a href="/columna/<%=User.alias%>.html"><%=User.first_name%> <%=User.last_name%></a>
		<%
			}
		%>
	</div>
	<div class="desc">
		<% if(User.description != null){ %>
			<%=User.description%>
		<%}%>
	</div>
</div>
</script>