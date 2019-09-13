define({ "api": [
  {
    "type": "post",
    "url": "/judgment/request",
    "title": "Уголвоный анализ",
    "name": "judgementRequest",
    "group": "judgement",
    "version": "0.1.0",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "age",
            "description": "<p>Возраст</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "article24_id",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "article_id",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "crime_date",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "gender",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "heavy",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "soft",
            "description": ""
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "status",
            "description": "<p>Status: 1=Success. 0=Error</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "error_message",
            "description": "<p>Error text</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result",
            "description": "<p>Result text</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"status\": 1,\n  \"error_message\": \"\",\n  \"result\": \"Some text...\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "api/modules/v1/controllers/JudgmentController.php",
    "groupTitle": "judgement"
  }
] });
