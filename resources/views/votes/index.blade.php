@if(Auth::user()->vote_counter <= 0) 
	<p>You can't vote anymore!</p>  	
@elseif(Auth::user()->vote_counter == 1)
	<p>You have only <span id="counter">1</span> vote left.</p>  	
@else
	<p>You have <span id="counter">{{Auth::user()->vote_counter}}</span> votes left.</p>
@endif 