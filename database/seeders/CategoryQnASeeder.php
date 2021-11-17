<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryQnASeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('faq_categories')->truncate();
        DB::table('faq_questions')->truncate();
        DB::table('faq_answers')->truncate();

        $categories = [
            '운영정책',
            '계정/인증',
            '구매/판매',
            '거래품목',
            '배터리',
            '이벤트/초대',
            '이용/재재',
            '기타',
            '떴다프로필',
            '주변꿀팁',
            '떴다광고'
        ];

        DB::table('faq_categories')->truncate();
        DB::table('faq_questions')->truncate();
        DB::table('faq_answers')->truncate();

        $catIds = [];
        foreach ($categories as $category) {
            $catIds[] = DB::table('faq_categories')->insertGetId([
               'content'      => $category,
                'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }

        $questions = [
            '팔로잉 사용자 관리',
            '차단 사용자 관리',
            '게시글 미노출 사용자 관리',
            '기타설정',
        ];

        foreach ($catIds as $catId) {
            foreach ($questions as $question) {
                $questionId = DB::table('faq_questions')->insertGetId([
                    'faq_category_id' => $catId,
                    'question'        => $question,
                    'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
                ]);

                DB::table('faq_answers')->insertGetId([
                    'faq_category_id'          => $catId,
                    'faq_category_question_id' => $questionId,
                    'answer'                   => '자주하는 질문에 대한 답변이 노출됩니다!',
                    'created_at'               => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at'               => Carbon::now()->format('Y-m-d H:i:s')
                ]);
            }
        }

        $this->useCategory();
        $this->guideLineUse();
    }

    public function useCategory()
    {
        $cateUseId = DB::table('faq_categories')->insertGetId([
            'content'      => '거래품목',
            'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        $questionUseId = DB::table('faq_questions')->insertGetId([
            'faq_category_id' => $cateUseId,
            'question'        => "거래가 안되는 물품이 뭘까요?",
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        $data = [
            [
                'faq_category_id' => $cateUseId,
                'faq_category_question_id' => $questionUseId,
                'answer'        => "거래금지품목은 이용약관 및 현행 법률에 따라 즉시 삭제 및 계정 차단이 될 수 있으므로 운영정책을 참고하셔서 이용 부탁 드립니다.",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateUseId,
                'faq_category_question_id' => $questionUseId,
                'answer'        => "개인정보 : 주민등록증, 면허증, 여권, 학생증, 대포통장, 사원증, 각종 자격증 등 ",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateUseId,
                'faq_category_question_id' => $questionUseId,
                'answer'        => "온라인 계정 : 카카오톡, 인스타, 페이스북, 네이버, 오버워치, 피파, 롤, 리니지, 각종 게임계정 등",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateUseId,
                'faq_category_question_id' => $questionUseId,
                'answer'        => "불법 및 사행성  : 대출, 리니지M , 토토, 화투, 포커, 한게임, 섯다, 바둑이, 바카라, 각종 불법도박 등",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateUseId,
                'faq_category_question_id' => $questionUseId,
                'answer'        => "청소년유해물품 : 성인잡지, DVD, 음반, 서적, 레이져포인터, 캠핑용 나이프, 눈알젤리, 가스건, 성인용품, 낙태유도제, 임신테스트기, 배란테스트기, 콘돔 등",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateUseId,
                'faq_category_question_id' => $questionUseId,
                'answer'        => "반려동물 : 무료분양, 열대어, 살아있는 동물 등",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateUseId,
                'faq_category_question_id' => $questionUseId,
                'answer'        => "종량제 봉투 : 국내 폐기물관리법상 개인이 판매할 수 없습니다.",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateUseId,
                'faq_category_question_id' => $questionUseId,
                'answer'        => "주류 및 담배 : 담배, 전자담배, 가루담배, 천연담배, 금연초, 소주, 맥주, 양주, 와인, 외국술, 막걸리, 위스키, 보드카, 고량주, 무알콜 맥주, 칵테일 등",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateUseId,
                'faq_category_question_id' => $questionUseId,
                'answer'        => "군용품류 : 총기, 전투복, 전투모, 전투화, 군마트용품, 경찰용품, 도검, 전기충격기, 석궁, 활, 칼, 안전인증표시 없는 전기용품 등",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateUseId,
                'faq_category_question_id' => $questionUseId,
                'answer'        => "의약품 : 감기약, 근육통약, 타이레놀, 알러지약, 각종 진통제, 수면제, 마취제, 프로포폴, 식욕억제제, 비아그라 등 의약성분이 포함된 각종 약품",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateUseId,
                'faq_category_question_id' => $questionUseId,
                'answer'        => "콘택트렌즈 및 안경 : 각종 렌즈, 도수안경, 도수 선글라스,",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateUseId,
                'faq_category_question_id' => $questionUseId,
                'answer'        => "불법시술 : 타투, 눈썹문신, 입술색문식, 속눈썹연장, 네일 포함 각종 출장 시술 등",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateUseId,
                'faq_category_question_id' => $questionUseId,
                'answer'        => "상품권 및 포인트 : 문화누리카드, 온누리, 지역사랑, 지역화폐, 티머니, 각종 사이트 포인트 할인판매 등",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateUseId,
                'faq_category_question_id' => $questionUseId,
                'answer'        => "불법 및 대포성 :  개인간 차량 렌트, 개통 휴대폰, 불법소프트웨어복제품, 신용불량자 휴대폰 개통 및 판매 등 법률을 위반하여 만들어진 모든 상품 등",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateUseId,
                'faq_category_question_id' => $questionUseId,
                'answer'        => "상표권/저작권 침해 상품 :  위조 상품, 이미테이션, 타인의 저작권이 있는 제품을 영리목적으로 판매하는 모든 경우 등",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateUseId,
                'faq_category_question_id' => $questionUseId,
                'answer'        => "화장품 : 화장품샘플, 증정품, 비매품, 각종 화장품 소분 판매 등",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateUseId,
                'faq_category_question_id' => $questionUseId,
                'answer'        => "유해화학물질 : 농약, 독극물 등 각종 모든 화학물질 등",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateUseId,
                'faq_category_question_id' => $questionUseId,
                'answer'        => "혈액(헌혈증) : 무료나눔만 가능합니다",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateUseId,
                'faq_category_question_id' => $questionUseId,
                'answer'        => "초소형 카메라 및 변형카메라 : 카메라를 이용하여 알아보기 어렵게 제작된 모든 물품",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateUseId,
                'faq_category_question_id' => $questionUseId,
                'answer'        => "암표 : 암표 거래시 떴다마켓 운영정책에 따라 게시가 제재 됩니다.",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateUseId,
                'faq_category_question_id' => $questionUseId,
                'answer'        => "수제음식 및 핸드메이드제품 : 과일청, 유자차, 꿀단지 등 제조 인허가를 받지 않은 개인이 직접 만들거나 가공한 음식 ,  이윤추구를 목적으로하는 핸드메이드 판매는 금합니다.",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateUseId,
                'faq_category_question_id' => $questionUseId,
                'answer'        => "목적없이 영리목적으로 제3자에게 자료 및 정보 제공 하는 경우 떴다마켓 운영정책에 따라 제재 됩니다.",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateUseId,
                'faq_category_question_id' => $questionUseId,
                'answer' => "위 거래금지품목 이외  전자상거래 또는 통신판매로 유통/판매가 금지되어 있거나, 사회통념상 매매에 부적합하다고 '회사'가 판단하는 경우 운영정책에 따라 제재 됩니다",
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];

        DB::table('faq_answers')->insert($data);
    }

    public function guideLineUse()
    {
        $cateGuideLineUseId = DB::table('faq_categories')->insertGetId([
            'content'      => '이용방법',
            'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        //Q1
        $questionGuideLineUseId1 = DB::table('faq_questions')->insertGetId([
            'faq_category_id' => $cateGuideLineUseId,
            'question'        => "물품등록방법이 궁금해요",
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        //Q2
        $questionGuideLineUseId2 = DB::table('faq_questions')->insertGetId([
            'faq_category_id' => $cateGuideLineUseId,
            'question'        => "계좌정보설정 방법이 궁금해요",
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        //Q3
        $questionGuideLineUseId3 = DB::table('faq_questions')->insertGetId([
            'faq_category_id' => $cateGuideLineUseId,
            'question'        => "배송지등록 방법이 궁금해요",
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        //Q4
        $questionGuideLineUseId4 = DB::table('faq_questions')->insertGetId([
            'faq_category_id' => $cateGuideLineUseId,
            'question'        => "거래 전에 확인사항이 궁금해요",
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        //Q5
        $questionGuideLineUseId5 = DB::table('faq_questions')->insertGetId([
            'faq_category_id' => $cateGuideLineUseId,
            'question'        => "판매자의 주의사항은 무엇인가요?",
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        //Q6
        $questionGuideLineUseId6 = DB::table('faq_questions')->insertGetId([
            'faq_category_id' => $cateGuideLineUseId,
            'question'        => "구매자의 주의사항은 무엇인가요 ?",
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        //Q7
        $questionGuideLineUseId7 = DB::table('faq_questions')->insertGetId([
            'faq_category_id' => $cateGuideLineUseId,
            'question'        => "안전하게 거래하는 방법은 무엇인가요 ?",
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        //Q8
        $questionGuideLineUseId8 = DB::table('faq_questions')->insertGetId([
            'faq_category_id' => $cateGuideLineUseId,
            'question'        => "떴다마켓의 정책은 무엇인가요 ?",
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        //Q9
        $questionGuideLineUseId9 = DB::table('faq_questions')->insertGetId([
            'faq_category_id' => $cateGuideLineUseId,
            'question'        => "토큰으로 결제 방법을 알고싶어요",
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        //Q10
        $questionGuideLineUseId10 = DB::table('faq_questions')->insertGetId([
            'faq_category_id' => $cateGuideLineUseId,
            'question'        => "프로필 사진 및 닉네임 등 정보를 변경하는 방법은 무엇인가요 ?",
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        //Q11
        $questionGuideLineUseId11 = DB::table('faq_questions')->insertGetId([
            'faq_category_id' => $cateGuideLineUseId,
            'question'        => "나의 중고 거래내역은 어디서 보나요 ?",
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        //Q12
        $questionGuideLineUseId12 = DB::table('faq_questions')->insertGetId([
            'faq_category_id' => $cateGuideLineUseId,
            'question'        => "상단으로 재노출은 어떻게 하나요 ?",
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        //Q13
        $questionGuideLineUseId13 = DB::table('faq_questions')->insertGetId([
            'faq_category_id' => $cateGuideLineUseId,
            'question'        => "상대방의 연락처를 알려주세요",
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        //Q14
        $questionGuideLineUseId14 = DB::table('faq_questions')->insertGetId([
            'faq_category_id' => $cateGuideLineUseId,
            'question'        => "동네인증 방법이 궁금해요",
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        //Q15
        $questionGuideLineUseId15 = DB::table('faq_questions')->insertGetId([
            'faq_category_id' => $cateGuideLineUseId,
            'question'        => "떴다마켓에서 인증된 업체는 믿을 수 있나요 ?",
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        //Q16
        $questionGuideLineUseId16 = DB::table('faq_questions')->insertGetId([
            'faq_category_id' => $cateGuideLineUseId,
            'question'        => "채팅방에 사진과 이모티콘을 보내고 싶어요.",
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        //Q17
        $questionGuideLineUseId17 = DB::table('faq_questions')->insertGetId([
            'faq_category_id' => $cateGuideLineUseId,
            'question'        => "이용제한의 경우는 무엇 때문인가요?",
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        //Q18
        $questionGuideLineUseId18 = DB::table('faq_questions')->insertGetId([
            'faq_category_id' => $cateGuideLineUseId,
            'question'        => "거래후기는 어떻게 쓰나요?",
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        //Q19
        $questionGuideLineUseId19 = DB::table('faq_questions')->insertGetId([
            'faq_category_id' => $cateGuideLineUseId,
            'question'        => "판매자와 채팅은 어떻게 하나요?",
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        //Q20
        $questionGuideLineUseId20 = DB::table('faq_questions')->insertGetId([
            'faq_category_id' => $cateGuideLineUseId,
            'question'        => "다른 지역에서 거래할 수 없나요?",
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        //Q21
        $questionGuideLineUseId21 = DB::table('faq_questions')->insertGetId([
            'faq_category_id' => $cateGuideLineUseId,
            'question'        => "물품 검색은 어떻게 하나요?",
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        //Q22
        $questionGuideLineUseId22 = DB::table('faq_questions')->insertGetId([
            'faq_category_id' => $cateGuideLineUseId,
            'question'        => "게시글은 어떻게 수정하나요?",
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        //Q23
        $questionGuideLineUseId23 = DB::table('faq_questions')->insertGetId([
            'faq_category_id' => $cateGuideLineUseId,
            'question'        => "게시글은 어떻게 삭제하나요?",
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        //Q24
        $questionGuideLineUseId24 = DB::table('faq_questions')->insertGetId([
            'faq_category_id' => $cateGuideLineUseId,
            'question'        => "관심있는 물건만 따로 보고싶어요.",
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        //Q25
        $questionGuideLineUseId25 = DB::table('faq_questions')->insertGetId([
            'faq_category_id' => $cateGuideLineUseId,
            'question'        => "예약중.거래완료 등의 거래상태 변경은 어떻게 하나요?",
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        //Q26
        $questionGuideLineUseId26 = DB::table('faq_questions')->insertGetId([
            'faq_category_id' => $cateGuideLineUseId,
            'question'        => "택배서비스는 없나요?",
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        //Q27
        $questionGuideLineUseId27 = DB::table('faq_questions')->insertGetId([
            'faq_category_id' => $cateGuideLineUseId,
            'question'        => "판매 잘하는 꿀팁",
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        //Q28
        $questionGuideLineUseId28 = DB::table('faq_questions')->insertGetId([
            'faq_category_id' => $cateGuideLineUseId,
            'question'        => "거래 약속 시간 전에 알림을 받고 싶어요.",
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        //Q29
        $questionGuideLineUseId29 = DB::table('faq_questions')->insertGetId([
            'faq_category_id' => $cateGuideLineUseId,
            'question'        => "알림확인은 어디에서 하나요?",
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        //Q30
        $questionGuideLineUseId30 = DB::table('faq_questions')->insertGetId([
            'faq_category_id' => $cateGuideLineUseId,
            'question'        => "알림을 받고싶지 않아요.",
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        $dataGuideLineUse = [
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId1,
                'answer'        => "물품등록방법",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId1,
                'answer'        => "첫째, 떴다마켓 → 오른쪽 하단에 연필모양 클릭 !",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId2,
                'answer'        => "계좌정보설정방법",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId2,
                'answer'        => "첫째, 채팅창 우측 상단에 계좌 보내기 클릭 !",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId2,
                'answer'        => "둘째, 계좌정보 입력 클릭 !",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId3,
                'answer'        => "배송지 등록방법",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId3,
                'answer'        => "첫째, 배송지 보내기 클릭 !",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId3,
                'answer'        => "둘째, 직접 입력하기 클릭 !",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId4,
                'answer'        => "궁금해요첫째, 직거래 (약속 시간과 장소를 정하기. 만나서 물건의 상태 확인 후 현금이나 계좌이체로",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],[
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId4,
                'answer'        => "둘째, 택배거래 (사기피해가 발생할 수 있으니 유의해 주세요!)",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],[
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId4,
                'answer'        => "가급적 택배거래보다 직거래 하는 것을 권장합니다 :)",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],[
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId5,
                'answer'        => "첫째, 서로간의 매너를 잘 지켜주세요",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId5,
                'answer'        => "둘째, 구매자의 비매너 행위나 불필요한 요구가 지속되는 등의 경우 우측 상단에 메",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId5,
                'answer'        => "셋째, 그 외에도 제품의 하자가 있는경우, 물건을 잘못 보냈을 경우 등 판매자의 잘못으로 인해 거래에 문제가 생긴 경우엔 즉시 환불 또는 취소를 해주셔야해요 ",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId6,
                'answer'        => "첫째, 서로간의 매너를 잘 지켜주세요",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId6,
                'answer'        => "둘째, 판매자의 비매너 행위나 택배거래시 선결제 요구, 물건을 보내주지 않는 경우 등의 문제가 발생 시 떴다마켓 고객센터로 문의주시거나, 우측 상단 메뉴표시를 누른 후 신고 OR 차단 기능이 있으니 이용해주세요.",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],[
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId6,
                'answer'        => "셋째, 그 외에도 구매자의 부주의로 제품의 문제가 생긴 경우, 판매자의 제품정보를 정확히 확인하지 않은 상태로 물건을 구입한 경우에는 거래 취소를 하기가 어려워요. 그러니 구매전에 꼭 상품의 정보를 확인해주세요 !",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId7,
                'answer'        => "첫째, 서로가 신뢰할 수 있게 직거래일 경우 약속장소에 가기 전 구매자의 경우엔 구매대금, 판매자의 경우엔 물건을 한번 더 체크합니다",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId7,
                'answer'        => "둘째, 택배거래일 경우 물건을 보내는 시간과 입금을 하는 시간을 맞춰주세요.  판매자는 물건을 보낸 사진과 송장번호를 전송하면 구매자는 사진을 받는 즉시 금액을 보내주세요.",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId7,
                'answer'        => "택배거래는 신뢰를 바탕으로 하다보니 서로간의 믿음과 약속을 중요하게 생각해주세요 !",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId8,
                'answer'        => "떴다마켓은 중고거래에 직접적으로 개입하지 않습니다.  다만 분쟁이 생겼을 경우 임의적으로 거래에 개입할 수는 있어요",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId8,
                'answer'        => "떴다마켓에서 임의적으로 개입하는 경우엔 상대방의 비매너적인 문제에 관해 제재를 가할 수 있으며, 문제가 심각할 경우엔 이용제재까지 행할 수 있어요",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId9,
                'answer'        => "토큰 결제 방법",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId9,
                'answer'        => "첫째, 토큰결제를 클릭해주세요",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId10,
                'answer'        => "마이 떴다 ▶ 상단에 편집버튼 클릭 ! ▶ 닉네임 or 프로필 사진 변경",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId11,
                'answer'        => "마이떴다☞중고거래내역☞판매버튼을 클릭하면 나의 중고 거래내역을 보실 수 있",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId12,
                'answer'        => "수정하려는 게시글☞하단에 있는 상단up 버튼 클릭☞재노출이 가능합니다.",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId13,
                'answer'        => "개인정보보호법에 의해 사용자의 연락처는 개인에게 알려줄 수 없어서 거래 당사자",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId14,
                'answer'        => "동네인증을 하기 전에 현재 내가 그 위치에 있는지 확인 후 인증해 주시면 됩니다.",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId15,
                'answer'        => "미정",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId16,
                'answer'        => "채팅방 접속☞채팅방 화면 하단의 +클릭☞카메라와 갤러리로 사진 올리는게 가능하고, +버튼 오른쪽에 보면 스마일이 하나 보이실거에요! 스마일을 클릭하면 떴다마켓만의 다양한 이모티콘 사용이 가능합니다:)",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId17,
                'answer'        => "떴다마켓에서는 거래에 직접적으로 개입하지는 않지만 특별한 상황에서는 이용제재를 가할 수 있어요 ",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId17,
                'answer'        => "첫째, 상대방과 조율하지 않은 상태로 물건금액을 하루이상 보내주지 않은경우",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId17,
                'answer'        => "둘째, 상대방에게 심한 욕설, 비방, 명예훼손, 성희롱, 성추행 등의 채팅을 보낸경우",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId17,
                'answer'        => "셋째, 직접거래 또는 택배거래를 진행하기로 한 뒤 아무런 연락 없이 거래를 피하는 경우에는 패널티가 쌓이며 3회 이상 쌓인 경우엔 이용제한됩니다.",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId17,
                'answer'        => "넷째, 거래와 관련없는 개인적인 홍보글도 이용에 제한됩니다.",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId18,
                'answer'        => "마이떴다☞중고거래내역☞판매☞거래된상품에 후기작성버튼☞후기를 바로 작성하실 수 있어요:)",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId19,
                'answer'        => "게시글 오른쪽 하단에 있는 채팅하기 클릭☞채팅방으로 이동☞채팅을 바로 시작할 수 있어요:)",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId20,
                'answer'        => "동네인증이 되어야만 다른 지역에서 거래가 가능하고, 동네인증은 실제 그 동네에 있을 때 받을 수 있답니다 :)",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId21,
                'answer'        => "상단의 돋보기 클릭☞물품을 검색하면 쉽게 보실 수 있으실 거에요:)",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId22,
                'answer'        => "올린게시물 클릭☞상단에 있는 점세개 버튼 클릭☞바로 수정이 가능해요:)",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId23,
                'answer'        => "올린게시물 클릭☞하단에 있는 삭제하기 클릭☞바로 삭제가 가능해요:)",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId24,
                'answer'          => "마이떴다☞하단에 좋아요 클릭☞좋아요 눌러둔 상품들만 확인이 가능해요!",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId25,
                'answer'          => "마이떴다☞중고거래내역☞판매☞변경하고싶은 상품 클릭☞판매상태☞판매중/예약중/거래완료 중 원하는 버튼 클릭으로 변경이 가능합니다!",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId26,
                'answer'          => "택배는 권장하지않아요. 가까운 동네이웃과 거래할 수 있는 만큼 직거래 하는 건 어떨까 싶습니다! 직거래로 중고거래의 빈번한 사기피해를 방지해보아요:)",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId27,
                'answer'          => "1.사진퀄리티,2.설명이 필요한 부분은 확대컷,3.시세에 맞는 가격 책정이 필요합니다 :)",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId28,
                'answer'          => "채팅창☞하단의 +버튼☞거래일정☞약속시간과 알림설정 클릭 후 원하는대로 설정☞약속시간 전에 알림이 옵니다 :)",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId29,
                'answer'          => "홈 화면☞오른쪽 상단 종 모양의 버튼클릭☞활동알림 / 키워드알림 수정☞바로 알림확인이 가능합니다.",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'faq_category_id' => $cateGuideLineUseId,
                'faq_category_question_id' => $questionGuideLineUseId30,
                'answer'          => "마이떴다☞톱니바퀴모양☞푸시설정 혹은 방해금지설정☞알림을 받지 않을 수 있어요.",
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
            ],
        ];

        DB::table('faq_answers')->insert($dataGuideLineUse);
    }
}
