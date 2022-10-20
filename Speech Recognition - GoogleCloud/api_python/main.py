from fastapi import FastAPI
from google.cloud import speech
from os.path import splitext
from pydub import AudioSegment
import os
os.environ["GOOGLE_APPLICATION_CREDENTIALS"] = "hearyourjsonfile.json"


samplerate = 16000
audiochanel=1
app = FastAPI()


@app.get("/speechsolvoapi")
def sendtextjson(filemp3:str,session:str):
    """Function to get json with text transcribe and timestamp acept videos <10MB and <60seconds
    Into: MP3 File Path D://XXXXX 
    Return: JSON {"TEXTO": "MP3 TRASNCRIBE TEXT", "TIMESTAMP"} """

    if(not filemp3):
        return {"Error":"Need a validate path"}

    #convert to flac audio file
    pathfile = mp3toflac(filemp3,session)

    if(pathfile == "error"):
        return {"error":"no es posible realizar la petición"}

    #transcribe with googleCloud for no cost only use file <10MB and <60seconds
    resultado = getTranscribe(pathfile)
    return resultado
    

def mp3toflac(filemp3:str,session:str)->str:
    """Funcion que pasa mp3 to flac
    Se realiza conversión dado que la libreria de google cloud speech se encuentra en desarrollo
    y pruebas en beta para mp3"""
    global samplerate,audiochanel

    try:
        newfile = "%s.flac" % splitext(filemp3)[0]
        newaudio = AudioSegment.from_mp3(filemp3)
        samplerate= newaudio.frame_rate
        audiochanel = newaudio.channels
        newaudio.export(newfile, format = "flac")
        return newfile
    except Exception as e:
        if hasattr(e, 'message'):
            print(e.message)
        else:
            print(e)
        
        return "error"




def getTranscribe(filemp3:str):
    """Function for transcribe the audio
    into:  .flac path the file on the server
    retur: JSON with the timestam and text the audio"""


    file_transcribe = filemp3
    client = speech.SpeechClient()

    with open(file_transcribe, "rb") as audio_file:
        content = audio_file.read()

    audio = speech.RecognitionAudio(content=content)

    config = speech.RecognitionConfig(
        encoding=speech.RecognitionConfig.AudioEncoding.FLAC,
        sample_rate_hertz=samplerate,
        language_code="en-US",
        audio_channel_count=audiochanel,
        enable_word_time_offsets=True,
    )

    operation = client.long_running_recognize(config=config, audio=audio)
    result = operation.result(timeout=90)
    arra_words=[]
    textoutput=""

    for result in result.results:
        textaudio = result.alternatives[0]
        textoutput = textoutput+textaudio.transcript+" "
        #print("-" * 20)
        #print(u"Transcript: {}".format(textaudio.transcript))
        #print(u"Channel Tag: {}".format(result.channel_tag))

        for getwords in textaudio.words:
            word = getwords.word
            start_time = getwords.start_time
            end_time = getwords.end_time

            arra_words.append({"word":word, "start_time": start_time.total_seconds(), "end_time": end_time.total_seconds()})

    return {"timestamp":arra_words,"text":textoutput}