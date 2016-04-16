<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
    pageEncoding="ISO-8859-1"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<script src="https://cdn.jsdelivr.net/vue/1.0.21/vue.min.js"></script>
  
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Insert title here</title>
</head>
<body>

<div id="complaints">
  Title: <input v-model="title" disabled>
  <br />
  Assigned To: <select v-model="assigned_user_id">
  <option v-for="user in users" v-bind:value="user.value">
    {{ user.text }}
  </option>
  </select>
  <br />
   Complaint Status: <select v-model="status">
  <option v-for="status in complaintStatuses" v-bind:value="status.value">
    {{ status.text }}
  </option>
</select>
  <br />
  Start Date: <input v-model="created_at" disabled>
  <br />
  Health Facility: <input v-model="facility_id" disabled>
  <br />
</div>

<div id="reply">

  <ul>
    <li v-for="reply in replies">
       User: <input v-model="reply.user_id" disabled>
       <br />
      <textarea v-model="reply.content" cols="100", rows="10" disabled="disabled"> </textarea>
      <br />
      <ul>
    	<li v-for="attachment in reply.attachments">
    	   <a href="attachment.filename" >{{attachment.filename}}</a>
    	</li>
      </ul>
      <!--  <span>{{ reply.text }}</span> -->
      <!--  <button v-on:click="removeReply($index)">X</button> -->
    </li>
  </ul>
  
  <textarea v-model="newReply" cols="100", rows="10"> </textarea>
  <br />
  <button v-on:click="addReply">Add Reply</button>
  
</div>

<script>

var complaints = new Vue({
	  el: '#complaints',
	  data: {
	    title: 'Complaint number 1',
	    assigned_user_id: 'Reviewer',
	    users: [
		    	{text: 'Reviewer', value: 'Reviewer'},
		    	{text: 'Complainant', value: 'Complainant'},
		    	{text: 'Complaint Handler', value: 'Complaint Handler'},
		    	{text: 'Health Facility', value: 'Health Facility'},
		    ],
	    status: 'Open',
	    complaintStatuses: [
	    	{text: 'Open', value: 'Open'},
	    	{text: 'Review', value: 'Review'},
	    	{text: 'Closed', value: 'Closed'}
	    ],
	    created_at: '04/16/2016',
	    facility_id: 'St. Lukes'
	  }
});
	
var reply = new Vue({
	  el: '#reply',
	  data: {
	    newReply: '',
	    user_id: 'tetsing',
	    replies: [
	      {   
	    	  user_id: 'Reviewer',
	    	  content: 'Customers 1st reply', 
	    	  attachments: [ {filename: "blahblah.txt"}, 
	    	                 {filename: "bitag.pdf"}
	    	               ]
	      }
	    ]
	  },
	  methods: {
	    addReply: function () {
	      var content = this.newReply.trim();
	      if (content) {
	    	//this.replies.push({ user_id: user_id });
	        this.replies.push({ user_id: 'Reviewer', content: 'Assigned to: ' + complaints.assigned_user_id + '\n' 
	        	                      + 'Status: ' + complaints.status + '\n' 
	        	                      + 'Content: ' + content });
	        this.newReply = '';
	      }
	    },
	    removeReply: function (index) {
	      this.replies.splice(index, 1);
	    }
	  }
	});
	
	
</script>


</body>
</html>