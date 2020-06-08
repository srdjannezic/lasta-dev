function initSliderManager(tableId, xml_options)
{
	jQuery(document).find('form').submit( function (){ buildSliderXML(tableId); } );
	loadSliderOptions(tableId, xml_options);
}

function loadSliderOptions(tableId, xml_options)
{
	if (window.DOMParser)
 	{
		parser = new DOMParser();
		xmlDoc = parser.parseFromString(xml_options, "text/xml");
	}
	else // Internet Explorer
	{
		xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
		xmlDoc.async = "false";
		xmlDoc.loadXML(xml_options);
	}
	
	jQuery("slide", xmlDoc).each( function() {
		var url = jQuery(this).attr('url');
		var slide_link = jQuery(this).attr('link');
		var duration = 10;
		if(jQuery(this).attr("duration"))
			duration = jQuery(this).attr("duration");

		var transition = "fade";
		jQuery("transition", this).each( function() {
			transition = jQuery(this).attr("type");
			if(transition == "slide")
				transition += jQuery(this).attr("direction");
		});

		var texts = Array();
		var ttimes = Array();
		var tcolors = Array();		
		var ttx = Array();		

		jQuery("info", this).each( function() {
			texts.push(jQuery(this).text());
			ttimes.push(jQuery(this).attr('intime'));
			tcolors.push(jQuery(this).attr('colorindex'));
			ttx.push(jQuery(this).attr('intx'));
		});
		
		texts.push(""); texts.push(""); texts.push("");
		ttimes.push(0); ttimes.push(0); ttimes.push(0);
		tcolors.push(0); tcolors.push(0); tcolors.push(0);
		ttx.push(0); ttx.push(0); ttx.push(0);
			
		var row = addSliderTableRow(tableId);
		
		/////////////////////////////////
		
		var selurl = jQuery('[name="url_select"]', row).find('option[value="' + url + '"]');
		if(url != "" && selurl.length > 0)
		{
			selurl.attr("selected", true);
			jQuery('[name="url"]', row).hide();
		}
		jQuery('[name="url"]', row).val(url);
		jQuery('[name="duration"]', row).val(duration);
		jQuery('[name="transition"]', row).find('option[value="' + transition + '"]').attr("selected", true);
		
		var selopt = jQuery(row).find('[name="multi_link_div"]').find('option[value="' + slide_link + '"]');
		if(selopt.length > 0)
		{
			jQuery(row).find('[name="multi_link_div"]').children('div').css({'display': 'none'}); 
			selopt.parent().parent().css({'display': 'inline'}); 
			selopt.attr("selected", true);
			var sel_type = selopt.parent().parent().attr('name').replace('_div', '');
			jQuery(row).find('[name="multi_link_select"]').find('option[value="' + sel_type + '"]').attr("selected", true);
		}
		else
		{
			jQuery(row).find('[name="multi_link_div"]').find('input').val(slide_link);
		}
		
		jQuery('[name="textsize"]', row).val(jQuery(this).attr('textsize'));
		jQuery('[name="textx"]', row).val(jQuery(this).attr('textx'));
		jQuery('[name="texty"]', row).val(jQuery(this).attr('texty'));
		jQuery('[name="textdir"]', row).find('option[value="' + jQuery(this).attr('textdir') + '"]').attr("selected", true);
		jQuery('[name="textalign"]', row).find('option[value="' + jQuery(this).attr('textalign') + '"]').attr("selected", true);
		
		jQuery('[name="text1"]', row).val(texts[0]);
		jQuery('[name="text1time"]', row).val(ttimes[0]);
		jQuery('[name="text1color"] option:eq(' + tcolors[0] + ')', row).attr('selected', 'selected');
		jQuery('[name="tx1"] option[value="' + ttx[0] + '"]', row).attr('selected', 'selected');
		
		jQuery('[name="text2"]', row).val(texts[1]);
		jQuery('[name="text2time"]', row).val(ttimes[1]);
		jQuery('[name="text2color"] option:eq(' + tcolors[1] + ')', row).attr('selected', 'selected');
		jQuery('[name="tx2"] option[value="' + ttx[1] + '"]', row).attr('selected', 'selected');
		
		jQuery('[name="text3"]', row).val(texts[2]);
		jQuery('[name="text3time"]', row).val(ttimes[2]);
		jQuery('[name="text3color"] option:eq(' + tcolors[2] + ')', row).attr('selected', 'selected');
		jQuery('[name="tx3"] option[value="' + ttx[2] + '"]', row).attr('selected', 'selected');

	});
}

function addSliderTableRow(tableId)
{
	var table = document.getElementById(tableId + '_table');	
	var template_row = document.getElementById(tableId + '_template_row');	
	var row = table.insertRow(table.rows.length);
	row.innerHTML = template_row.innerHTML;
	row.setAttribute('name', 'slider_row');
	return row;
}

function buildSliderXML(id)
{
	var colors = Array(' colorindex="0" color1="FFE25A" color2="FFBD00" ', 
					   ' colorindex="1" color1="EC0089" color2="93004F" ', 
					   ' colorindex="2" color1="FFFFFF" color2="F0F0F0" ',
					   ' colorindex="3" color1="006837" color2="39B54A" ',
					   ' colorindex="4" color1="C1272D" color2="FF0000" ',
					   ' colorindex="5" color1="662D91" color2="93278F" ',
					   ' colorindex="6" color1="1B1464" color2="2E3192" '
	);
	var res = '<slides>';
	var table = document.getElementById(id + '_table');

	for (var i = 0; i < table.rows.length; i++)
	{
		var row = table.rows[i];
		if(row.getAttribute('name') != "slider_row")
			continue;
		
		var url = jQuery(row).find('[name="url"]').val();		
		var duration = jQuery(row).find('[name="duration"]').val();
		var transition = jQuery(row).find('[name="transition"]').val();

		var linkdivs = jQuery(row).find('[name="multi_link_div"]').find('div');
		var muindex = jQuery(row).find('[name="multi_link_select"]').attr('selectedIndex');
		var slide_link = jQuery(linkdivs[muindex]).find('select, input').val();
		
		var textSize = jQuery(row).find('[name="textsize"]').val();
		var textx = jQuery(row).find('[name="textx"]').val();
		var texty = jQuery(row).find('[name="texty"]').val();
		var textDir = jQuery(row).find('[name="textdir"] option:selected').val();
		var textAlign = jQuery(row).find('[name="textalign"] option:selected').val();

		res += '<slide url="' + url + '" link="' + slide_link + '" duration="' + duration + '" textsize="' + textSize + '" textx="' + textx + '" texty="' + texty + '" textdir="' + textDir + '" textalign="' + textAlign + '">';
		res += '<transition';
		if(transition == "fade")
			res += ' type="fade"';
		else
			res += ' type="slide" direction="' + transition.substr(5) + '"';
		res += "/>";
		
		var text = jQuery(row).find('[name="text1"]').val().trim();
		var time = jQuery(row).find('[name="text1time"]').val();
		var color = jQuery(row).find('[name="text1color"] option:selected').val();
		var tx = jQuery(row).find('[name="tx1"] option:selected').val();
		if(text != "")
			res += '<info font="Cocon-Regular" intime="' + time + '" intx="' + tx + '" ' + colors[color] + '><![CDATA[' + text + ']]></info>';
		
		var text = jQuery(row).find('[name="text2"]').val().trim();
		var time = jQuery(row).find('[name="text2time"]').val();
		var color = jQuery(row).find('[name="text2color"] option:selected').val();
		var tx = jQuery(row).find('[name="tx2"] option:selected').val();
		if(text != "")
			res += '<info font="Cocon-Regular" intime="' + time + '" intx="' + tx + '" ' + colors[color] + '><![CDATA[' + text + ']]></info>';
		
		var text = jQuery(row).find('[name="text3"]').val().trim();
		var time = jQuery(row).find('[name="text3time"]').val();
		var color = jQuery(row).find('[name="text3color"] option:selected').val();
		var tx = jQuery(row).find('[name="tx3"] option:selected').val();
		if(text != "")
			res += '<info font="Cocon-Regular" intime="' + time + '" intx="' + tx + '" ' + colors[color] + '><![CDATA[' + text + ']]></info>';
		
		res += '</slide>';		
	}
	
	res += "</slides>";
	//alert(res);
	var res_field = document.getElementById(id);	
	res_field.value = res;
}
