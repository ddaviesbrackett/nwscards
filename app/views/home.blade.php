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
    <center><img src="/images/logo.png"></center>
	<h1>Buy Grocery Cards<br/>Raise Money</h1>
        
	<h3>
            This year we've raised so far - {{{money_format('$%n',$totalThisYear)}}}<br/>
            From July 2014 we've raised - {{{money_format('$%n',$total)}}}<br/>
            Help us raise more &mdash; <em>without spending any extra!</em>
        </h3>
        <br>
        <img src="https://grocerycards.nelsonwaldorf.org/images/saveon-coop.png" title="Save On Foods and Coop">
        
        <br>
        
	<p>Generously supported by our store partners The Kootenay Co-Op and Save-On Foods</p>
       
	@if (Sentry::check())
		<a class="btn btn-outline-inverse btn-lg" href="/edit">Change Order</a>
	@else
		<a class="btn btn-outline-inverse btn-lg" href="/new">Order Now</a>
	@endif
	<a class="link order" href="/account">Checking on an existing order? Click here</a>

        @if(OrderController::IsBlackoutPeriod() )
        <br><span style="color:yellow;"><b>Unfortunately, you can't order now while we process orders.<br>You will be able to make changes again from the next pick-up Wednesday until the following order deadline.</b></span>
        @endif 
</div>
<div class="container-fluid text-center">
        <a name="pickupdates"></a>
        <h2>Dates for 2021 - 2022:</h2>
        <center>
            <table border="0" width="400px;">
            <tr>
                <td align="center" style="padding-right:10px;"><b>Change deadline</b></td>
                 <td align="center"><b>Pick up day</b></td>
            </tr>
           <tr>
                <td align="center">September 14th 2021</td>
                <td align="center">September 22th 2021</td>
            </tr>
           <tr>
                <td align="center">October 12th 2021</td>
                <td align="center">October 20th 2021</td>
            </tr>
           <tr>
                <td align="center">November 9th 2021</td>
                <td align="center">November 17th 2021</td>
            </tr>
            <tr>
                <td align="center">December 7th 2021</td>
                <td align="center">December 15th 2021</td>
            </tr>            
           <tr>
                <td align="center">Winter Break</td>
                <td align="center">Winter Break</td>
            </tr>            
            <tr>
                <td align="center">January 4th 2022</td>
                <td align="center">January 12th 2022</td>
            </tr>            
            <tr>
                <td align="center">February 1st 2022</td>
                <td align="center">February 9th 2022</td>
            </tr>  
            <tr>
                <td align="center">March 1st 2022</td>
                <td align="center">March 9th 2022</td>
            </tr> 
            
           <tr>
                <td align="center">Spring Break</td>
                <td align="center">Spring Break</td>
            </tr>
           <tr>
                <td align="center">April 5th 2022</td>
                <td align="center">April 13th 2022</td>
            </tr>          
           <tr>
                <td align="center">May 3rd 2022</td>
                <td align="center">May 11th 2022</td>
            </tr>
           <tr>
                <td align="center">May 31st 2022</td>
                <td align="center">June 8th 2022</td>
            </tr>
            </table>
            </center>
        <br>
	<a name="about"></a>
	<h2>ALL SCHOOL SUPPORT AND ENHANCEMENT</h2>
	<p>
        The Nelson Waldorf School Parent Council runs this school-wide grocery card fundraiser to help classes raise money for their activities (like class trips or class play support) and to raise money for all school support and enhancement, such as playgrounds and buildings maintenance and improvement, teachers professional development and tuition assistance. 	 	
        Your grocery card order helps keep the Nelson Waldorf School vibrant and diverse. 	
        If you would like to donate to the school directly and receive a tax receipt:<br>
        <a href="http://www.canadahelps.org/CharityProfilePage.aspx?CharityID=d39625">click here to donate through CanadaHelps.org</a>.</p>
        
	<a name="method"></a>
	<h2>How we raise money from your groceries</h2>
	<p>
		When you purchase a grocery card through the Nelson Waldorf Parent Council, the store donates 8% of the card value to us. So on each $100 card you buy, we make $8... 
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
	        <p>
                    The funds are being distributed between the classes (50%), all school support and enhancement (45%)  and Parent Council (5%). The Parent Council amount will cover administrative costs for this fundraiser as well as fund other projects that benefit the whole school.</p>
			<p>All of the profits will be held and managed by the Parent Council until it is donated to the school or distributed to an individual class.</p>
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
	        <p>You can pick up your cards on the Wednesday following your charge dates (which depends on whether you have ordered bi-weekly or monthly). You will receive an email a few days before reminding you of the pickup day.</p>
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
	        <a data-toggle="collapse" data-parent="#accordion" href="#faq37">
	          When do I order?
	        </a>
	      </h4>
	    </div>
	    <div id="faq37" class="panel-collapse collapse">
	      <div class="panel-body">
	        <p>To put in an order or to order extra cards you have until Tuesday midnight the week before the next pick-up-Wednesday. If you can't order now (while we process orders), you will be able to make changes again from the next pick-up Wednesday until the following order deadline.</p>
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
	        <p>You can change an existing order with <a href="/edit">this form</a>. You have until Tuesday midnight the week before the next pick-up-Wednesday to change your order. Please note that you can't change your order while orders are being processed. “If you can't order now (while we process orders), you will be able to make changes again from the next pick-up Wednesday until the following order deadline.</p>
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
	        <p>You can change an existing order with <a href="/edit">this form</a>. You have until Tuesday midnight the week before the next pick-up-Wednesday to change your order. Please note that you can't change your order while orders are being processed. If you can't cancel order now (while we process orders), you will be able to make changes again from the next pick-up Wednesday until the following order deadline.</p>
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
	        <p>Your order is good for the whole school year. We’ll take a break over the summer holidays - so you’ll get no cards in July and August. With the start of the new school year your order will resume automatically with the amounts you’ve ordered - so you’ll get your ordered cards again in September. </p>
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
                        <p>
                            However, most classes do have cards available for cash purchases – and those sales support that particular class. Please check with your class grocery cards person to buy cash cards from her/him!
Also, Parent Council has cards available for cash purchases on pick-up days. However, these sales will not be tracked for class accounts. Instead, all of the proceeds from these sales will go to all school support and enhancement and Parent Council.
                        </p>
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
	        <p>Your class teacher and class rep can request money from us when it’s needed. Requests can be made using <a href="https://docs.google.com/uc?authuser=0&id=0B2sI4qt1poXCOERSNnZnbFpEWms&export=download">this form</a>. Completed forms can be left at the School office or handed to one of the Grocery Card fairies (at pick-up-Wednesday). </p>
			<p>Because this fundraiser requires a larger amount of cash to float each purchase of cards, all the money raised will be held by the Parent Council and used for that purpose until the class needs it.</p>
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
	          Does this mean Parent Council is raising money for the classes?
	        </a>
	      </h4>
	    </div>
	    <div id="faq13" class="panel-collapse collapse">
	      <div class="panel-body">
	        <p>No. This is one way that your class can raise money. We've set up the system - now it's up to your class as to how much you raise based on orders connected to your class. So sign up! Sign up friends and family! Or buy cards for cash and send people to your Class Grocery Cards Rep!</p>
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
                                <li>Buying grocery cards for cash from your Class Grocery Cards Rep</li>
                                <li>Sending people to your Class Grocery Cards Rep for cash purchases</li>
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
                  <p>You can make a one-time-order and designate your child’s class as the beneficiary. <a class="btn btn-danger btn-lg" href="/new">Sign up here</a></p>
                  <p>You can buy cards for cash from your class grocery cards rep. The proceeds of those cards will benefit your child’s class.</p>
	        <p>You can sign up other people to buy grocery cards (friends, neighbours, family members) and ask them to designate your child’s class as the beneficiary.</p>
			<p>Parent Council will have some cards available for cash purchase on pick-up Wednesdays. These sales will benefit all school support and enhancement – but they won’t be tracked for class accounts.</p>
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
	        <p>Sure. You can donate directly to this program and have the funds divided between the all school support and enhancement program and class accounts.</p>
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
	        <p>You will not get a tax receipt for the money raised with this fundraiser. The Nelson Waldorf Parent Council is not a registered charity.</p>
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
		This fundraiser is being run by the Parent Council, not the school administration.
	</p>
	<p>
		Thanks for your understanding. 
	</p>
</div>
@stop