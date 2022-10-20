# Speech Recognition

#Demo

Video: https://youtu.be/AW67lsjGCGk
URL: http://18.223.105.203:8086/development/speechapi/web/index.php



# Backend

Requirements
	* Python 3.10 
	* Google Cloud Library pip install --upgrade google-cloud-speech
	* Billing Count on Google Cloud - You can to start here : https://cloud.google.com/speech-to-text/docs/transcribe-client-libraries
	* Fast API 
		command : pip install fastapi
	* Uvicorn
		command: pip install uvicorn


REST API development on Python 3.10, the API receive the .mp3 file and the idsession, this API process the file and transform then on .FLAC 
for better transcribe with google-cloud-speech, detect sample rate, and detect number of chanel from the audio. The transcription is maked with google-cloud-speechfor this your need a account on google-cloud and billing account. Remember you have 60min for month free, and for use free you need to upload mp3 with no more than 60seconds and smaller than 10Mb. 

Visit https://cloud.google.com/speech-to-text/docs/transcribe-client-libraries form more detail about this library.

In the Code you need your JSON for your credential with google-cloud.

View the code on backend folder main.py, and use to start api start_api.py for enabled the REST-API server.


# Frontend

Requirements

	* PHP 7.4+
	* FrameWork YII2 (download the application is on YII2 ready to use)
	
	
The frontend is on a PHP FrameWork YII2, with jQuery. This framework interact with the user, and save log on table Events on DataBase.


# DataBase

Requirements
	*PostgresSQL 12







	


	












