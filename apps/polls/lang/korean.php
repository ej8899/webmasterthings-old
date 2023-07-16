<?php
# Advanced Poll Language File (Admin) #
#
# 제목: 한국어 설정
#
# 1. 설치 경로의 lang 폴더로 korean.php를 복사
#
# 2. 계정의 admin으로 로그인 후, 환경설정에서 사용언어를 korean으로 적용
#
# 3. 설치된 디렉토리 안의 모든 파일에서 언어를 한글완성형(charset=ks_c_5601-1987)으로 변경
#
# 끝
#
# mailto: webmaster@blackcrow.co.kr
# 모든 파일의 언어를 한글 완성형(charset=ks_c_5601-1987)으로 수정하세요. #

# Charset
$charset   = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=ks_c_5601-1987\">";

# General
$Logout    = "로그아웃";
$FormUndo  = "취 소";
$FromClear = "취 소";
$FormEnter = "사용자 이름 및 암호를 입력하세요 !";
$FormWrong = "사용자 이름 또는 암호가 틀립니다 !";
$FormOK    = "확 인";
$Updated   = "설정하신 내용을 변경했습니다.";
$NoUpdate  = "에러 발생 !  변경된 사항이 없습니다 !";
$Confirm   = "실행 할까요 ?";
$NavNext   = "다음 페이지";
$NavPrev   = "이전 페이지";
$License   = "라이센스 동의";
$ScrollTxt = "동의 내용을 더 보시려면 페이지 다운키를 누르세요.";

# Poll List
$IndexTitle  = "투표목록";
$IndexQuest  = "질 문";
$IndexID     = "투표 ID";
$IndexDate   = "요일";
$IndexDays   = "일";
$IndexExp    = "투표기간";
$IndexExpire = "투표종료";
$IndexNever  = "무기한";
$IndexStat   = "현재상황";
$IndexCom    = "의견보기";
$IndexAct    = "삭제하기";
$IndexDel    = "삭제";

# Create A New Poll
$NewTitle  = "투표만들기";
$NewOption = "선 택";
$NewNoQue  = "질문 내용을 입력하세요 !";
$NewNoOpt  = "선택 내용을 입력하세요 !";

# Poll Edit
$EditStat  = "투표보기";
$EditText  = "아래 투표를 편집합니다.";
$EditReset = "투표 초기화";
$EditOn    = "투표사용";
$EditOff   = "사용안함";
$EditHide  = "투표숨김";
$EditLgOff = "작성안함";
$EditLgOn  = "로그작성";
$EditAdd   = "선택 추가하기";
$EditNo    = "선택이 추가되지 않았습니다 !";
$EditOk    = "선택이 추가되었습니다 !";
$EditSave  = "변경하기";
$EditOp    = "선택은 최소 2개 이상 입력해야 합니다 !";
$EditMis   = "질문 또는 선택이 정의되지 않았습니다 !";
$EditDel   = "투표기간을 설정하려면 체크하지 마세요 !";
$EditCom   = "의견사용";

# General Settings
$SetTitle   = "환경설정";
$SetOption  = "테이블, 글꼴 및 색상 선택";
$SetMisc    = "기타 설정";
$SetText    = "환경설정 변경";
$SetURL     = "이미지 디렉토리 경로";
$SetNo      = "경로구분은 /로 할 것.";
$SetLang    = "사용 언어";
$SetPoll    = "투표 제목";
$SetButton  = "버튼 이름";
$SetResult  = "결과 보기";
$SetVoted   = "투표했을 경우";
$SetComment = "의견 보내기";
$SetTab     = "테이블 너비";
$SetBarh    = "막대 높이";
$SetBarMax  = "막대 최대 길이";
$SetTabBg   = "테이블 배경색";
$SetFrmCol  = "표 색상";
$SetFontCol = "글꼴 색상";
$SetFace    = "글꼴 종류";
$SetShow    = "투표결과 출력방식";
$SetPerc    = "백분율";
$SetVotes   = "참가인원";
$SetCheck   = "점검사항";
$SetNoCheck = "사용안함";
$SetIP      = "IP 테이블";
$SetTime    = "마감";
$SetHours   = "시간";
$SetOffset  = "서버 갱신시간";
$SetEntry   = "페이지당 의견 출력 수";
$SetSubmit  = "저 장";
$SetEmpty   = "설정이 누락 또는 잘못되었습니다.";

# Change Password
$PwdTitle = "암호변경";
$PwdText  = "사용자 이름 또는 암호 변경";
$PwdUser  = "사용자 이름";
$PwdPass  = "암호";
$PwdConf  = "암호 확인";
$PwdNoUsr = "사용자 이름을 확인하세요.";
$PwdNoPwd = "암호를 확인하세요.";
$PwdBad   = "암호가 일치하지 않습니다.";

# Poll Stats
$StatCrea  = "만든날짜";
$StatAct   = "경과시간";
$StatReset = "투표기록 삭제";
$StatDis   = "이 투표는 기록을 볼 수 없습니다.";
$StatTotal = "총 투표 수";
$StatDay   = "일일 투표 수";

# Poll Comments
$ComTotal  = "총 의견 수";
$ComName   = "이 름";
$ComPost   = "배달일";
$ComDel    = "이 메세지를 지울까요 ?";

# Help
$Help      = "도움말";
$HelpPoll  = "아래 태그를 투표를 원하는 웹페이지에 삽입하세요.";
$HelpRand  = "무작위로 투표를 출력 할 경우:";
$HelpNew   = "마지막 만든 투표를 출력 할 경우:";

# Days
$weekday[0] = "일요일";
$weekday[1] = "월요일";
$weekday[2] = "화요일";
$weekday[3] = "수요일";
$weekday[4] = "목요일";
$weekday[5] = "금요일";
$weekday[6] = "토요일";

# Months
$months[0]  = "1월";
$months[1]  = "2월";
$months[2]  = "3월";
$months[3]  = "4월";
$months[4]  = "5월";
$months[5]  = "6월";
$months[6]  = "7월";
$months[7]  = "8월";
$months[8]  = "9월";
$months[9]  = "10월";
$months[10] = "11월";
$months[11] = "12월";

# Colors
$color_array[0]  = "녹청색";
$color_array[1]  = "청색";
$color_array[2]  = "갈색";
$color_array[3]  = "진녹색";
$color_array[4]  = "황금색";
$color_array[5]  = "녹색";
$color_array[6]  = "회색";
$color_array[7]  = "주황색";
$color_array[8]  = "분홍색";
$color_array[9]  = "자주색";
$color_array[10] = "적색";
$color_array[11] = "노란색";

?>