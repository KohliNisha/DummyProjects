
var formatDecimal = function(amount) {
    return amount.toFixed(2);
    };
	var $slider = $('#slider');
	var $sliderValue = $('#loancalculatoruserslidervalues');
	var $periodButtons = $('.loantimeduration');
	var showingAll = false;
	var store = [];
	var selected = {
	period: '6',
	amount: 500
	};
	loansCalculator(selected.amount, selected.period);
	$slider.slider({
    range: "min",
    value: 500,
    step: 1,
    min: 500,
    max: 10000,
    slide: function( event, ui ) {
			$sliderValue.val( ui.value );
			renderValidState();
			selected.amount =  ui.value;
			//console.log("selected amount"+selected.amount);
			$sliderValue.html(selected.amount);
			loansCalculator(selected.amount, selected.period);
    },
	
});



	function renderValidState() {
		$('.validation-message-box').hide();
	}

	function renderInvalidState() {
		$('.validation-message-box').show();
	}
    $sliderValue.on('keyup', function(e) {
	 if (!this.value) return;
      try {
				var inputValue = parseInt(this.value);
        if (inputValue >= 500 && inputValue <= 10000) {
           $(this).val(inputValue);
		  loansCalculator(inputValue, selected.period);
		  $slider.slider("value", parseInt(inputValue));
		  renderValidState();
        } else {
          renderInvalidState();
        }
      } catch(e) {
        renderInvalidState();
      }
    });
	$sliderValue.on('keydown', function(e) {
	 if (!this.value) return;
      try {
		var inputValue = parseInt(this.value);
        if (inputValue >= 5000 && inputValue <= 10000) {
           $(this).val(inputValue);
		  loansCalculator(inputValue, selected.period);
		  $slider.slider("value", parseInt(inputValue));
		  renderValidState();
        } else {
          renderInvalidState();
        }
      } catch(e) {
        renderInvalidState();
      }
    });

   $periodButtons.click(function() {
		var newPeriod = $(this).val();
		if (selected.period === newPeriod) return;
		selected.period = newPeriod;
		$periodButtons.removeClass('loan-calculator_period-control_menuitem--active');
		$('.loan-calculator_period-control_menuitem[value="'+selected.period+'"]')
		.addClass('loan-calculator_period-control_menuitem--active');


         var $sliderValue = $('#loancalculatoruserslidervalues').val();        
		 if($sliderValue < 500 || $sliderValue > 10000){
		 	$finalAmt = selected.amount ;            
		 } else {
		 	$finalAmt = $sliderValue;
		 }
		//alert($finalAmt);


		loansCalculator($finalAmt, selected.period);
	});
	
	function loansCalculator (loanamount, instalments) {
		//First, converting R percent to r a decimal
		 rate = 32/100;
		 if(instalments == 6){
			SI = (parseFloat(loanamount) * rate * 0.5)
			weeks = 26;
		}else if(instalments ==12){
			SI = (parseFloat(loanamount) * rate * 1)
			weeks = 52;
		}
		total = (parseFloat(loanamount) + parseFloat(SI))
		instalmentperweek = total / weeks;
		instalmentperday = instalmentperweek / 7;
		$('.totalamountwithtax').html(formatDecimal(total));
		$('.weeklypaymentamount').html(formatDecimal(instalmentperweek));
		$('.dailypaymentamount').html(formatDecimal(instalmentperday));
    }
