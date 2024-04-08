<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>card</title>
  <link rel="stylesheet" href="./Profile-card.css" />
  <script src="https://kit.fontawesome.com/66aa7c98b3.js" crossorigin="anonymous"></script>
  <style>
      * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

.front {
    font-family: 'Times New Roman', Times, serif;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: linear-gradient(#52A20A, #66B71C 45%, #66B71C 45%, #8DF130 100%);
}

.back{
    font-family: 'Times New Roman', Times, serif;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: linear-gradient(#52A20A, #66B71C 45%, #66B71C 45%, #8DF130 100%);
}

.back-content{
    display: flex;
    flex-direction: column;
    line-height: 15px;
    text-align: left;
}
.rule {
    width: 100%;
    border-top: 2px dashed #ffff;
    margin-bottom: 15px;
}

.page-break {
    page-break-after: always;
}

.card {
    position: relative;
    width: 300px;
    height: 400px;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    margin-top: 20px;
}

.img-bx {
  position: relative;
  width: 200px;
  height: 200px;
  border: 4px dashed #ffff;
  border-radius: 50%;
  overflow: hidden;
  margin-bottom: 20px;
}

.img-bx img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  border-radius: 50%;
  object-fit: cover;
}


.school-name {
    background-color: #ffff;
    text-align: center;
    padding: 15px;
    border-radius: 10px;
    margin: 15px 0 15px 0;
}
.header{
    display: flex;
    text-align: center;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}
.content{
    display: flex;
    line-height: 15px;
    text-align: left;
}
  </style>
</head>
<body>
    <div class="front">
        <div class="header">
            <img style="display: block;" src="https://res.cloudinary.com/jdlab-ng/image/upload/v1611918269/ibb_u7mdeo.png" alt="Company Logo" width="100">
            <div class="school-name">
               Ibrahim Badamasi Babangida University, Lapai
            </div>
            <div>
                Niger, Nigeria
            </div>
        </div>
      <div class="card">
        <div class="img-bx">
          <img src="https://i.postimg.cc/dQ7zWbS5/img-4.jpg" alt="img" />
        </div>
        <div>
            <div class="content">
                <div style="margin-right: 15px;">
                    <p>Name: </p>
                    <p>Matric Number: </p>
                    <p>School/Faculty: </p>
                    <p>Programme: </p>
                    <p>Level: </p>
                    <p>Expiry: </p>
                </div>
                <div>
                    <p>Jane Doe</p>
                    <p>U24/FNS/CSC/0001</p>
                    <p>Natural Science</p>
                    <p>Computer Science</p>
                    <p>100</p>
                    <p>Dec, 2028</p>
                </div>
            </div>
        </div>
      </div>
    </div>
    <div class="page-break"></div>
    <div class="back">
        <div class="header">
            <div class="school-name" style="color: black;">
               School Policies
            </div>
        </div>
      <div class="card">
        <div style="text-align: left; margin-bottom: 20px;">
            <p style="margin-bottom: 15px;">* This ID card is a property of Ibrahim Badamasi Babangida University, Lapai</p>
            <p>* Replacement cards can be obtained for a fee of N3,000 </p>
        </div>
        <div>
            <div class="back-content" style="text-align: center;">
                <div style="margin: 50px 0 50px 0">
                    <p>Report lost or stolen ID card immediately to the school office or call 08030303030</p>
                </div>
                <div style="margin: 0 0 20px 0">
                    <div class="rule"></div>
                    <p>Provost</p>
                </div>
                <div>
                    <img src="https://th.bing.com/th/id/OIP.NDKNbQ-I9ApLLVp-E6HSPwHaHa?rs=1&pid=ImgDetMain" width="100" alt="QR Code">
                </div>
            </div>
        </div>
      </div>
    </div>
</body>
</html>
