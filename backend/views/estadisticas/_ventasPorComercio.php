<?php
use sjaakp\gcharts\ColumnChart;
?>

<?= ColumnChart::widget([
    'height' => '400px',
    'dataProvider' => $dataProvider,
    'columns' => [
		"nombre",
		"cnt",
		/*[               // third column: tooltip
			'value' => function($model) {
				return $model->sum('cantidad');;
			},
			'type' => 'int',
			'role' => 'tooltip',
		],          // second column: data
        [               // third column: tooltip
            'value' => function($model) {
				return $model->sum('cantidad');;
            },
            'type' => 'int',
            'role' => 'tooltip',
        ],*/
    ],
    'options' => [
        'title' => 'EU: Gross Domestic Product per Capita',
    ],
]) ?>