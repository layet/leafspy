<?php
if ($this->owner->name=='panel') {
	$out['CONTROLPANEL']=1;
}

$rec = SQLSelect("SELECT * FROM `leaf_spy_properties` WHERE CAR_ID='$id'");

$ok = 1;

if ($this->mode == 'update') {
	//updating car record
	if ($ok) {
		foreach ($rec as $key => $item) {
			$old_linked_object = $item['LINKED_OBJECT'];
			$old_linked_property = $item['LINKED_PROPERTY'];

			global ${'linked_object' . $item['ID']};
			$rec[$key]['LINKED_OBJECT'] = ${'linked_object' . $item['ID']};
			global ${'linked_property' . $item['ID']};
			$rec[$key]['LINKED_PROPERTY'] = ${'linked_property' . $item['ID']};
			global ${'linked_method' . $item['ID']};
			$rec[$key]['LINKED_METHOD'] = ${'linked_method' . $item['ID']};

			//if ($key == 24) print_r($rec[$key]);
			SQLUpdate('leaf_spy_properties', $rec[$key]);

			if ($old_linked_object != $rec[$key]['LINKED_OBJECT'] && $old_linked_property != $rec[$key]['LINKED_PROPERTY']) {
				removeLinkedProperty($old_linked_object, $old_linked_property, $this->name);
			}

			if ($rec[$key]['LINKED_OBJECT'] && $rec[$key]['LINKED_PROPERTY']) {
				addLinkedProperty($rec[$key]['LINKED_OBJECT'], $rec[$key]['LINKED_PROPERTY'], $this->name);
			}
		}

		$out['OK'] = 1;
	} else {
		$out['ERR'] = 1;
	}
}

if (is_array($rec)) {
	foreach($rec as $k=>$v) {
		if (!is_array($v)) {
            $rec[$k] = htmlspecialchars($v);
		}
	}
}
$out['CAR_ID'] = $this->id;
outHash($rec, $out['RESULT']);
