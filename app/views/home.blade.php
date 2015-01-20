@extends('layout')

@section('title')
	Home
@stop

@section('head-extra')
	<link rel="stylesheet" href="/styles/home.css"/>
	<script src="/script/home.js"></script>
@stop

@section('nav-extra')
	<li><a href="#about">About</a></li>
	<li><a href="#faq">FAQ</a></li>
	<li><a href="#contact">Contact</a></li>
@stop

@section('content')
<div class="masthead">
	<h1>Buy Grocery Cards<br/>Raise Money</h1>
	<h3>We've raised ${{{$total}}} so far<br/>Help us raise more &mdash; <em>without spending any extra!</em></h3>
	<p>Generously supported by our store partners The Kootenay Co-Op and Save-On Foods</p>
	@if (Sentry::check())
		<a class="btn btn-outline-inverse btn-lg" href="/edit">Change Order</a>
	@else
		<a class="btn btn-outline-inverse btn-lg" href="/new">Order Now</a>
	@endif
	<a class="link order" href="/account">Checking on an existing order? Click here</a>
</div>
<div class="container-fluid text-center">
	<a name="about"></a>
	<h2>Waldorf Education for Every Child</h2>
	<p>
		Did you know the Nelson Waldorf School has a generous tuition reduction program? 
		No family is turned away for financial reasons. 
	</p>
	<p>
		To ensure that accessibility contuinues, the Nelson Waldorf School Parent Association
		is running a school-wide grocery card fundraiser to support a tuition reduction fund,
		individual classes and other all-school projects, such as playground maintenance and improvement.  
	</p>
	<p>
		Your grocery card order helps keep the Nelson Waldorf School available to all families who want it.
	</p>
	<p>
		If you would like to donate to the school directly &mdash; and receive a tax receipt &mdash; 
		<a href="http://www.canadahelps.org/CharityProfilePage.aspx?CharityID=d39625">click here to donate through CanadaHelps.org</a>.
	</p>
	<a name="method"></a>
	<h2>How we raise money from your groceries</h2>
	<p>
		When you purchase a grocery card through the Nelson Waldorf Parent Association, the store donates a percentage of its profit to us. 
	</p>
	<p>
		We raise money and it doesn’t cost you a cent – the money comes out of the store’s pocket.
	</p>
	<a name="faq"></a>
	<h2>Frequently Asked Questions</h2>

	<div class="panel-group" id="accordion">
	  <div class="">
	    <div class="panel-heading">
	      <h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#faqOne">
	          Where does the money go?
	        </a>
	      </h4>
	    </div>
	    <div id="faqOne" class="panel-collapse collapse">
	      <div class="panel-body">
	        <p>The funds are being distributed between the classes, the tuition reduction fund and the Parent Association. The Parent Association amount will cover administrative costs for this fundraiser as well as fund other projects that benefit the whole school.</p>
			<p>All of the profits will be held and managed by the Parent Association until it is donated to the school or distributed to an individual class.</p>
	      </div>
	    </div>
	  </div>
	  <div class="">
	    <div class="panel-heading">
	      <h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#faqTwo">
	          What stores can I buy cards from - and are you adding more?
	        </a>
	      </h4>
	    </div>
	    <div id="faqTwo" class="panel-collapse collapse">
	      <div class="panel-body">
	        <p>We are currently selling cards from the Kootenay Co-Op and Save-On Foods.  Once this fundraiser is established, we may approach other stores.</p>
		</div>
	    </div>
	  </div>
	  <div class="">
	    <div class="panel-heading">
	      <h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#faqTwoA">
	          How can I pay?
	        </a>
	      </h4>
	    </div>
	    <div id="faqTwoA" class="panel-collapse collapse">
	      <div class="panel-body">
	        <p>You can pay by direct debit or credit card.</p>
			<p>However because of the fees associated with using a credit card, we do not receive the full amount of what you are charged. This means your order raises less money than the same order paid with by direct debit.</p>
			<p>But that doesn’t mean it’s always better to pay with debit. If paying by credit card allows you to make a larger order, then credit card is better.  The larger the order, the more money is raised.</p>
		</div>
	    </div>
	  </div>
	  <div class="">
	    <div class="panel-heading">
	      <h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#faqThree">
	          When do I get charged?
	        </a>
	      </h4>
	    </div>
	    <div id="faqThree" class="panel-collapse collapse">
	      <div class="panel-body">
	        <p>Regardless of your method of payment, you will be charged 2 business days before your cards are available.</p>
			<p>If there is a problem with your payment, we will contact you. Credit card orders can be retried – or you may bring cash to pick-up. Debit orders cannot be retried and can only be picked up with cash.</p>
	      </div>
	    </div>
	  </div>
	  <div class="">
	    <div class="panel-heading">
	      <h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#faq4">
	          How do I get my cards?
	        </a>
	      </h4>
	    </div>
	    <div id="faq4" class="panel-collapse collapse">
	      <div class="panel-body">
	        <p>Cards can be picked up at the Nelson Waldorf School or mailed to you.</p>
			<p>We will email you at the beginning of the week to remind you that cards will be ready for pick up on Wednesday. </p>
			<p>If you choose to have your cards mailed, they will be mailed on Wednesday following your charge date. We will also email you to remind you they are coming. Generally, cards have been arriving in Thursday’s mail for people in Nelson.</p>
	      </div>
	    </div>
	  </div>
	  <div class="">
	    <div class="panel-heading">
	      <h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#faq5">
	          When do I pick up my cards?
	        </a>
	      </h4>
	    </div>
	    <div id="faq5" class="panel-collapse collapse">
	      <div class="panel-body">
	        <p>You can pick up your cards on the Wednesday following your charge dates (which depends on whether you have ordered bi-weekly or monthly). You will recieve and email a few days before reminding you of the pickup day.</p>
			<p>We will be at the bottom of the main stairs between 8 – 8.30am and 2.30 – 3pm under the grocery cards banner.</p>
	      </div>
	    </div>
	  </div>
	  <div class="">
	    <div class="panel-heading">
	      <h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#faq6">
	          Can someone else pick up my cards for me?
	        </a>
	      </h4>
	    </div>
	    <div id="faq6" class="panel-collapse collapse">
	      <div class="panel-body">
	        <p>Yep. Just let us know who the other authorized person is by putting their name in the box that appears when you select ‘pick up’ on the order form.</p>
	      </div>
	    </div>
	  </div>
	  <div class="">
	    <div class="panel-heading">
	      <h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#faq7">
	          How do I change my order?
	        </a>
	      </h4>
	    </div>
	    <div id="faq7" class="panel-collapse collapse">
	      <div class="panel-body">
	        <p>You can change an existing order with <a href="/edit">this form</a>. Please note that you can't change your order while orders are being processed.</p>
	      </div>
	    </div>
	  </div>
	  <div class="">
	    <div class="panel-heading">
	      <h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#faq8">
	          How do I cancel my order?
	        </a>
	      </h4>
	    </div>
	    <div id="faq8" class="panel-collapse collapse">
	      <div class="panel-body">
	        <p>Contact us using <a href="#contact">the form below</a> – and we’ll help you out.</p>
			<p>Please note we require 10 days’ notice to cancel an order.</p>
	      </div>
	    </div>
	  </div>
	  <div class="">
	    <div class="panel-heading">
	      <h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#faq9">
	          How long is my order good for?
	        </a>
	      </h4>
	    </div>
	    <div id="faq9" class="panel-collapse collapse">
	      <div class="panel-body">
	        <p>The last order for this school year will be June 3. </p>
			<p>You will be given the opportunity to renew your order if you would like to continue.</p>
	      </div>
	    </div>
	  </div>
	  <div class="">
	    <div class="panel-heading">
	      <h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#faq10">
	          Do I have to make an order – can’t I just buy cards when I need them?
	        </a>
	      </h4>
	    </div>
	    <div id="faq10" class="panel-collapse collapse">
	      <div class="panel-body">
	        <p>Because we receive such a small amount for each card sold, the best way to raise money is to have recurring orders.</p>
			<p>We may have some cards available for cash purchases on pick-up days. However, these sales will not be tracked for class accounts. Instead, all of the proceeds from these sales will go to the tuition reduction fund and PAC.</p>
			<p>Some classes may also have cards available for cash purchases – and those sales will support that particular class.</p>
	      </div>
	    </div>
	  </div>
	  <div class="">
	    <div class="panel-heading">
	      <h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#faq11">
	         How does the class get the money they have raised?
	        </a>
	      </h4>
	    </div>
	    <div id="faq11" class="panel-collapse collapse">
	      <div class="panel-body">
	        <p>Your class teacher and class rep can request money from us when it’s needed. Requests need to be submitted to grocerycards{AT}nelsonwaldorf.org. </p>
			<p>Because this fundraiser requires a larger amount of cash to float each purchase of cards, all the money raised will be held by the Parent Association and used for that purpose until the class needs it.</p>
	      </div>
	    </div>
	  </div>
	  <div class="">
	    <div class="panel-heading">
	      <h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#faq12">
	          How do we know how much money the class has raised?
	        </a>
	      </h4>
	    </div>
	    <div id="faq12" class="panel-collapse collapse">
	      <div class="panel-body">
	        <p>You can see how much each class has raised on the <a href="/tracking/leaderboard">main tracking page</a> - or by clicking the class link on your account page.</p>
	      </div>
	    </div>
	  </div>
	  <div class="">
	    <div class="panel-heading">
	      <h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#faq13">
	          Does this mean PAC is raising money for the classes?
	        </a>
	      </h4>
	    </div>
	    <div id="faq13" class="panel-collapse collapse">
	      <div class="panel-body">
	        <p>No. We’re running this fundraiser, but you have to sign up for it to work. Sign up your friends, your neighbours and obviously yourself. </p>
			<p>A class will only have access to the funds they have already raised.</p>
	      </div>
	    </div>
	  </div>
	  <div class="">
	    <div class="panel-heading">
	      <h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#faq14">
	          How can our class raise more money?
	        </a>
	      </h4>
	    </div>
	    <div id="faq14" class="panel-collapse collapse">
	      <div class="panel-body">
	        <p>You can increase the funds in your class accounts by
	        <ul>
				<li>Increasing your current orders </li>
				<li>Encouraging more families in your class to participate</li>
				<li>Signing up friends, neighbours and family to support your class</li>
			</ul>
			</p>
	      </div>
	    </div>
	  </div>
	  <div class="">
	    <div class="panel-heading">
	      <h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#faq15">
	          I can’t make a regular order – how can I participate?
	        </a>
	      </h4>
	    </div>
	    <div id="faq15" class="panel-collapse collapse">
	      <div class="panel-body">
	        <p>You can sign up other people to buy grocery cards (friends, neighbours, family members) and ask them to designate your child’s class as the beneficiary.</p>
			<p>PAC will have some cards available for cash purchase on pick-up days. These sales will benefit the tuition reduction fund and PAC projects – but they won’t be tracked for class accounts.</p>
	      </div>
	    </div>
	  </div>
	  <div class="">
	    <div class="panel-heading">
	      <h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#faq16">
	          Can I just donate?
	        </a>
	      </h4>
	    </div>
	    <div id="faq16" class="panel-collapse collapse">
	      <div class="panel-body">
	        <p>Sure. You can donate directly to this program and have the funds divided between the tuition reduction program and class accounts.</p>
			<p>Or you can make a tax-deductible donation to the Nelson Waldorf School – <a href="http://www.canadahelps.org/CharityProfilePage.aspx?CharityID=d39625">click here to donate through CanadaHelps.org</a>. </p>
	      </div>
	    </div>
	  </div>
	  <div class="">
	    <div class="panel-heading">
	      <h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#faq17">
	          Will I get a tax receipt?
	        </a>
	      </h4>
	    </div>
	    <div id="faq17" class="panel-collapse collapse">
	      <div class="panel-body">
	        <p>You will not get a tax receipt for the money raised with this fundraiser. The Nelson Waldorf Parent Association is not a registered charity.</p>
	      </div>
	    </div>
	  </div>
	</div>
	<p style="margin-top:3em;">
		@if (Sentry::check())
			<a class="btn btn-danger btn-lg" href="/edit">Change Order</a>
		@else
			<a class="btn btn-danger btn-lg" href="/new">Order Now</a>
		@endif
	</p>
	<a name="contact"></a>
	<h2>Got another question? We've got answers</h2>
	<p>
		We'd love to hear from you.
	</p>
	<p>
			If you have a question or a concern about your order, you can reach us at grocerycards{AT}nelsonwaldorf.org or use the form below.
	</p>
	{{Form::open(['url'=>'/contact', 'method'=>'POST', 'class'=>'form contact'])}}
		<div class="row">
		<div class="col-sm-8 col-sm-push-2">
			<div class="callout" style='margin-top:20px;'>
			  <div class="error alert alert-danger alert-dismissible hidden" role="alert">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<span class="content"></span>
			  </div>
			  <div class="form-group">
			    <label for="nm">Name</label>
			    <input type="text" class="form-control nm" id="nm" name="nm" placeholder="your name">
			  </div>
			  <div class="form-group">
			    <label for="password">Email address</label>
			    <input type="email" class="form-control em" id="em" name="em" placeholder="your email address">
			  </div>
			  <div class="form-group">
			    <label for="password">Message</label>
			    <textarea class="form-control msg" id="msg" name="msg" placeholder="your message" rows="6"></textarea>
			  </div>
			  <button type="submit" class="btn btn-danger">Send</button>
			</div>
			<div class="success alert alert-success alert-dismissible hidden" role="alert">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<span class="content"></span>
			</div>
		</div>
		</div>
	{{Form::close()}}
	<p>	We will get back to you as soon as possible – usually the same day, but definitely within two business days.</p>
	<p>
		Please do not phone the Nelson Waldorf School unless it has been much longer than that. 
		This fundraiser is being run by the Parent Association, not the school administration.
	</p>
	<p>
		Thanks for your understanding. 
	</p>
</div>
@stop