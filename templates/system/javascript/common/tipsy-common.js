// <![CDATA[
	$(document).ready(function(){
		$('.tip-br').tipsy({ gravity: 'nw'});
		$('.tip-bc').tipsy({gravity: 'n'});
		$('.tip-bl').tipsy({gravity: 'ne'});		
		$('.tip-r').tipsy({gravity: 'w'});
		$('.tip-l').tipsy({gravity: 'e'});		
		$('.tip-tr').tipsy({gravity: 'sw'});
		$('.tip-tc').tipsy({gravity: 's'});
		$('.tip-tl').tipsy({gravity: 'se'});				
		// nw | n | ne | w | e | sw | s | se
		$('.formTip').tipsy({trigger: 'hover', gravity: 's'});
	});
// ]]>							