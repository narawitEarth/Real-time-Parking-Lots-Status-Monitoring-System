import tensorflow as tf
import tensornets as nets
import cv2
import numpy as np
import time
import itertools
import os
import psycopg2


DATABASE_URL = 'postgres://fmzgvjhzkhtmjj:6b48e81209e4c25ff3b7c98cbc8a662026da9332e811546e5990e1043fec336d@ec2-3-231-46-238.compute-1.amazonaws.com:5432/d221s9usaeehfi'
conn = psycopg2.connect(DATABASE_URL, sslmode='require')

cursor = conn.cursor()

##DRAW REC 1st live
rect = (0,0,0,0)
startPoint = False
endPoint = False

def on_mouse(event,x,y,flags,params):

    global rect,startPoint,endPoint

    # get mouse click
    if event == cv2.EVENT_LBUTTONDOWN:

        if startPoint == True and endPoint == True:
            startPoint = False
            endPoint = False
            rect = (0, 0, 0, 0)

        if startPoint == False:
            rect = (x, y, 0, 0)
            startPoint = True
        elif endPoint == False:
            rect = (rect[0], rect[1], x, y)
            endPoint = True


# my Rectangle = (x1, y1, x2, y2), a bit different from OP's x, y, w, h
def intersection(rectA, rectB): # check if rect A & B intersect
    a, b = rectA, rectB
    startX = max( min(a[0], a[2]), min(b[0], b[2]) )
    startY = max( min(a[1], a[3]), min(b[1], b[3]) )
    endX = min( max(a[0], a[2]), max(b[0], b[2]) )
    endY = min( max(a[1], a[3]), max(b[1], b[3]) )
    if startX < endX and startY < endY:
        return True
    else:
        return False


inputs = tf.placeholder(tf.float32, [None, 416, 416, 3])
model = nets.YOLOv3COCO(inputs, nets.Darknet19)
#model = nets.YOLOv2(inputs, nets.Darknet19)

#'0':'person','1':'bicycle','2':'car','3':'bike','5':'bus','7':'truck''
classes={'2':'car'}
list_of_classes=[2]
with tf.Session() as sess:
    sess.run(model.pretrained())
    
#"D://pyworks//yolo//videoplayback.mp4"

    
#http://192.168.137.49:31531/videostream.cgi?user=admin&pwd=TApop123 lot1
#http://192.168.137.23:45699/videostream.cgi?user=admin&pwd=TApop123 lot2
    #cap = cv2.VideoCapture("D://User//Test//Car Detection//cars.mp4")
    cap = cv2.VideoCapture('http://192.168.137.23:45699/videostream.cgi?user=admin&pwd=TApop123')
    #frame=cv2.imread("D://User//Test//Vehicle-and-people-tracking-with-YOLOv3--master//test.jpg",1)
    #subtractor = cv2.createBackgroundSubtractorMOG2()
    # point1 = (116 , 200)
    # point2 = (270,400)
    check = -2
    #pic=10
    while(cap.isOpened()):
        ret, frame = cap.read()
        #ret, img = cap.read()
        img=cv2.resize(frame,(416,416))
        imge=np.array(img).reshape(-1,416,416,3)
        #cv2.rectangle(img, point1, point2, (0, 0, 255),1) #Draw Parking Bounding Box
        start_time=time.time()
        preds = sess.run(model.preds, {inputs: model.preprocess(imge)})
        
        #mask = subtractor.apply(img)
        
        #print("--- %s seconds ---" % (time.time() - start_time)) 
        boxes = model.get_boxes(preds, imge.shape[1:3])
        cv2.namedWindow('image',cv2.WINDOW_NORMAL)
        #cv2.imwrite('D://User//Test//Vehicle-and-people-tracking-with-YOLOv3--master//test.jpg',img)
        cv2.resizeWindow('image', 700,700)
        cv2.setMouseCallback('image', on_mouse)
        #drawing rectangle
        if startPoint == True and endPoint == True:
            cv2.rectangle(img, (rect[0], rect[1]), (rect[2], rect[3]), (255, 0, 255), 2)
        #print("--- %s seconds ---" % (time.time() - start_time)) 
        boxes1=np.array(boxes)
        for j in list_of_classes:
            count =0
            over = 0
            park = 3
            if str(j)                             in classes:#name
                lab=classes[str(j)]
            if len(boxes1) !=0:              
                for i in range(len(boxes1[j])):
                    box=boxes1[j][i]
                    
                    if boxes1[j][i][4]>=.40:
                        count += 1
                        cv2.rectangle(img,(box[0],box[1]),(box[2],box[3]),(0,255,0),1)
                        cv2.putText(img, lab, (box[0],box[1]), cv2.FONT_HERSHEY_SIMPLEX, .5, (0, 0, 255), lineType=cv2.LINE_AA)
                        
                        #rect1 = (116 , 200,270,400)
                        rect1 = (rect[0],rect[1],rect[2],rect[3])
                        if(intersection(rect1,box)):
                            over+=1
                            #print("Overlapping")
                            cv2.rectangle(img,(box[0],box[1]),(box[2],box[3]),(0,0,255),1)
                            cv2.putText(img, lab, (box[0],box[1]), cv2.FONT_HERSHEY_SIMPLEX, .5, (0, 0, 255), lineType=cv2.LINE_AA)
                        
            free = park-over
            if(free<=0):
                free = 0
            print("Detect Car: ",count)
            print("Car Parked: ", free)
            if(check != free): #Free Change
               
                cursor.execute("INSERT INTO park2(detect,time) VALUES ({},CURRENT_TIMESTAMP)".format(free))
                conn.commit()
                #cv2.imwrite('D://User//Test//ProjectParkingDetection//CapImg2//Picture_{}_{}.jpg'.format(pic,free),img)
               # pic+=1
                print("Before Check: ",check)
                check = free
                print("After Check: ",check)
            cv2.putText(img, "Free Space: "+str(free), (250, 50) , cv2.FONT_HERSHEY_SIMPLEX, .5, (0, 255, 0), lineType=cv2.LINE_AA)
            
        cv2.imshow("image",img)  
        #cv2.imshow("Mask",mask)
        if cv2.waitKey(1) & 0xFF == ord('q'):
            break


#conn.commit()

cap.release()
cv2.destroyAllWindows()    
