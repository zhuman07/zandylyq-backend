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
            "type": "Object",
            "optional": false,
            "field": "result",
            "description": "<p>Result object</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.text_1",
            "description": "<p>Result param 1</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.text_2",
            "description": "<p>Result param 2</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.text_3",
            "description": "<p>Result param 3</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.text_4",
            "description": "<p>Result param 4</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.text_5",
            "description": "<p>Result param 5</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.text_6",
            "description": "<p>Result param 6</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "result.text_7",
            "description": "<p>Result param 7</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n  \"status\": 1,\n  \"error_message\": \"\",\n  \"result\": {\n     \"text_1\": \"some text...\",\n     \"text_2\": \"some text...\",\n     \"text_3\": \"some text...\",\n     \"text_4\": \"some text...\",\n     \"text_5\": \"some text...\",\n     \"text_6\": \"some text...\",\n     \"text_7\": \"some text...\"\n  }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 400 Bad Request\n{\n  \"status\": 0,\n  \"result\": {\n     \"text_1\": \"\",\n     \"text_2\": \"\",\n     \"text_3\": \"\",\n     \"text_4\": \"\",\n     \"text_5\": \"\",\n     \"text_6\": \"\",\n     \"text_7\": \"\"\n  },\n  \"error_message\": \"Пустое значение article_id. Пустое значение article24. Пустое значение gender. Пустое значение age. Ошибка значения soft. Ошибка значение heavy. Пустое значение crime_date\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "api/modules/v1/controllers/JudgmentController.php",
    "groupTitle": "judgement"
  }
] });
