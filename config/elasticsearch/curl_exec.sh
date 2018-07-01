###Delete board index##########
curl -XDELETE 'http://localhost:9200/board?pretty'

###Create board index##########
curl -XPUT -H 'content-type: application/json' 'http://localhost:9200/board?pretty' -d '@analyzer/cherrypick_analyzer.json'

###Create board mapping##########
curl -XPUT -H 'content-type: application/json' 'http://localhost:9200/board/_mapping/v1?pretty' -d '@mappings/board_mapping.json'
