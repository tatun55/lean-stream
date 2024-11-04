<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/css/style.css">
    <title>マンション管理サポート | 株式会社レクシード</title>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-16683057880"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'AW-16683057880');
    </script>
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body data-theme="light">
    <header class="bg-blue-900 text-center h-10 text-[#FF0]">
        <div class="relative max-w-[1600px] mx-auto">
            <h1 class="text-center text-[clamp(12px,1.5vw,18px)] font-bold leading-10">マンション組合理事・代表・オーナー様・住人のみなさん必見！</h1>
            <a href="#enquiry" class="block pt-3 h-full text-[clamp(15px,1.8vw,26px)] leading-[33px] font-bold">
                <div class="max-w-[328px] w-[23%] max-h-[120px] px-[1%] pb-[1.5%] pt-[1%] bg-[#70AF52] rounded-b-[20px] shadow-[0_4px_6px_rgba(0,0,0,0.25),0_-4px_4px_rgba(0,0,0,0.25)_inset] text-center absolute top-0 right-[4%] max-lg:hidden z-10 text-shadow">
                    <p>お問い合わせ・ご相談</p>
                    <p>お申込み</p>
                </div>
            </a>
        </div>
    </header>
    <main>
        <div class="relative max-h-[1400px] overflow-hidden">
            <img class="w-full h-full object-cover max-lg:hidden" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/FV.jpg" alt="">
            <div class="relative block lg:hidden">
                <img class="w-full" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/FV-sp.jpg" alt="">
                <div class="absolute top-0 left-0 w-full h-full"></div>
            </div>
            <div class="absolute top-0 max-w-[1600px] mx-auto pt-[4%] pl-[6%] max-lg:p-4">
                <h2 class="text-[#002C80] text-[clamp(18px,3vw,34px)] font-extrabold text-shadow max-lg:pt-8">
                    経験豊富なマンション管理士が<br>
                    皆さまの大切な資産を守る
                </h2>
                <div class="relative">
                    <img class="pt-[13%] pl-[25px] max-lg:p-10 max-lg:pt-[55px]" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/logo.png" alt="">
                    <a href="{{ route('login') }}" class="hidden lg:block text-[#4E4168] underline ml-8 pt-8 inline-block">契約済ユーザー様のログインはこちら</a>
                </div>
            </div>
        </div>
        <section class="bg-[#35495e] w-full text-center p-3 py-6 lg:hidden">
            <button class="block mx-auto font-bold text-[#FF0] text-[24px] bg-[#70AF52] rounded-[20px] p-4 max-lg:text-[18px] shadow-[0_4px_4px_rgba(0,0,0,0.25)]">
                <a href="#enquiry" class="text-shadow-none hover:text-shadow-lg">お問い合わせ・ご相談・お申込み</a>
            </button>
            <a href="{{ route('login') }}" class="inline-block lg:hidden pt-4 text-white underline">契約済ユーザー様のログインはこちら</a>
        </section>
        <section class="bg-[#E3F3F9] pt-5">
            <div>
                <h3 class="text-[clamp(22px,2.5vw,32px)] py-20 components-heading max-md:pb-3">マンション管理の様々な問題 こんな事にお困りの点ありませんか？</h3>
            </div>
            <div class="flex gap-[50px] max-md:flex-col max-md:gap-0">
                <div class="max-md:hidden"><img class="max-width-none" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/illustration-1.png" alt=""></div>
                <div class="md:hidden"><img class="mx-auto max-md:w-[50%]" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/illustration-1-sp.png" alt=""></div>
                <div class="flex flex-col flex-grow gap-[16px]">
                    <div class="components-1">
                        <div class="w-[38px] flex-shrink-0 max-md:w-[30px]"><img class="w-full h-full" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/icon-1.png" alt=""></div>
                        <div class="components-2">
                            <p>不具合発生時や修繕依頼したい時に</p>
                            <p>工事会社が見つからない</p>
                        </div>
                    </div>
                    <div class="components-1">
                        <div class="w-[38px] flex-shrink-0 max-md:w-[30px]"><img class="w-full h-full" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/icon-1.png" alt=""></div>
                        <div class="components-2">
                            <p>見積もりが適正価格なのかわからない</p>
                            <p>大規模修繕（外壁・耐震）をどうやって発注すればいいのかわからない</p>
                        </div>
                    </div>
                    <div class="components-1">
                        <div class="w-[38px] flex-shrink-0 max-md:w-[30px]"><img class="w-full h-full" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/icon-1.png" alt=""></div>
                        <div class="components-2">
                            <p>長期修繕計画（国のルールで必須）がつくれない</p>
                        </div>
                    </div>
                    <div class="components-1">
                        <div class="w-[38px] flex-shrink-0 max-md:w-[30px]"><img class="w-full h-full" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/icon-1.png" alt=""></div>
                        <div class="components-2">
                            <p>相見積もり（複数の工事会社に見積りをとる）の知識がなくわかないことが多い</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="components-heading text-[clamp(18px,2.5vw,30px)] py-20">
                <p>マンション管理は日々起こる問題や法律などの知識が必要。</p>
                <p>専門的な知識が必要な時代来ています。</p>
            </div>
        </section>
        <section class="bg-[#4E4168]">
            <div class="relative text-white components-heading text-left text-[clamp(18px,2.5vw,41px)] pt-32 pb-12 img-after max-md:pt-[15px] max-md:pb-[12px]">
                <div class="flex items-center justify-between">
                    <h3>
                        <p>さらに、マンション管理に</p>
                        <p>将来の不安こんなことに困っていませんか</p>
                    </h3>
                    <div class="md:hidden"><img class="w-[150px]" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/illustration-2-sp.png" alt=""></div>
                </div>
                <div><img class="absolute top-[80px] right-0 max-md:hidden md:w-[21%]" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/illustration-2.png" alt=""></div>
            </div>
            <div>
                <div class="max-md:mr-0 components-3 relative">
                    <div class="w-[38px] flex-shrink-0 max-md:w-[30px] max-md:-mt-1 absolute"><img class="w-full h-full" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/icon-1.png" alt=""></div>
                    <div class="max-md:pl-10 pl-12">マンション管理組合理事の後継者にふさわしい人がいない。</div>
                </div>
                <div class="max-md:mr-0 components-3 relative">
                    <div class="w-[38px] flex-shrink-0 max-md:w-[30px] max-md:-mt-1 absolute"><img class="w-full h-full" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/icon-1.png" alt=""></div>
                    <div class="max-md:pl-10 pl-12">住民だけで管理するのは大変。専門家のアドバイスがほしい。</div>
                </div>
                <div class="max-md:mr-0 components-3 relative">
                    <div class="w-[38px] flex-shrink-0 max-md:w-[30px] max-md:-mt-1 absolute"><img class="w-full h-full" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/icon-1.png" alt=""></div>
                    <div class="max-md:pl-10 pl-12">将来の修繕費にきちんと備えられるのか。物価上昇が心配。</div>
                </div>
            </div>
            <div>
                <p class="text-white text-[clamp(16px,2.5vw,30px)] font-extrabold pt-12 pb-28 text-center">マンション管理の後継者問題や管理費などの根本的な問題もあります</p>
            </div>
        </section>
        <section class="relative bg-[#EDBC41] triangle-1">
            <div class="py-[20px] max-md:py-[10px]">
                <h3 class="components-heading text-white text-[clamp(14px,2.5vw,30px)]">マンション管理の日々起こる問題や将来の問題</h3>
            </div>
        </section>
        <section class="relative">
            <div id="section-back-image" class="absolute h-[5000px] w-full -z-10"></div>
            <div class="text-[#4E4168] components-heading pt-[8%] pb-[5%] text-[clamp(22px,2.5vw,43px)] max-md:pt-[6%] max-md:pb-[2%]">
                <h3>どんなマンション管理の悩みもお気軽に相談ください</h3>
            </div>
            <div class="max-w-[1300px]">
                <img class="max-width" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/illustration-3.png" alt="">
            </div>
            <div class="max-w-[1200px] mx-auto text-[#FFFF00] text-center text-[clamp(12px,2.5vw,36px)] font-extrabold mb-[53px] max-md:mb-[25px]">
                <div class="bg-[#70AF52] py-[1%] px-[4%] rounded-[36px]">
                    <p>身近な問題から将来不安まで、スッキリと解決します</p>
                </div>
            </div>
            <div class="flex gap-[24px] mb-16 text-[#4E4168] font-extrabold max-md:flex-col max-md:mb-8">
                <div class="relative w-[100%] bg-[#E2F6F9] rounded-[12px] pt-[42px] pb-[49px] pl-[16px] max-md:pt-[13px] max-md:pb-[16px] max-md:pl-[60px]">
                    <p class="text-[clamp(14px,2vw,26px)]">マンション管理士は</p>
                    <p class="text-[clamp(28px,2vw,36px)]">国家資格<span class="text-[clamp(14px,2vw,26px)]">で安心</span></p>
                    <img class="absolute bottom-0 right-2 max-md:w-[60px] max-md:right-11" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/illustration-4.png" alt="">
                </div>
                <div class="relative w-[100%] bg-[#E2F6F9] rounded-[12px] pt-[42px] pb-[49px] pl-[16px] max-md:pt-[13px] max-md:pb-[16px] max-md:pl-[60px]">
                    <p class="text-[clamp(14px,2vw,26px)]">マンション管理士は</p>
                    <p class="text-[clamp(28px,2vw,36px)]">公平公正<span class="text-[clamp(14px,2vw,26px)]">で安心</span></p>
                    <img class="absolute bottom-0 right-2 max-md:w-[65px] max-md:right-11" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/illustration-5.png" alt="">
                </div>
                <div class="relative w-[100%] bg-[#E2F6F9] rounded-[12px] pt-[42px] pb-[49px] pl-[16px] max-md:pt-[13px] max-md:pb-[16px] max-md:pl-[60px]">
                    <p class="text-[clamp(14px,2vw,26px)]">マンション管理の</p>
                    <p class="text-[clamp(28px,2vw,36px)]">経験豊富</p>
                    <img class="absolute bottom-0 right-2 max-md:w-[70px] max-md:right-11" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/illustration-6.png" alt="">
                </div>
            </div>
            <div class="my-[75px] max-md:my-[40px]">
                <div class="max-w-[700px] mx-auto bg-[#70AF52] rounded-[22px] text-[#fff] text-center font-bold text-[clamp(16px,2vw,28px)] mb-[40px] max-md:mb-[15px]">
                    <p>マンション管理士導入のメリット その1</p>
                </div>
                <div class="components-heading text-[clamp(15px,2vw,30px)]">
                    <p>工事発注・見積・作業品質までを</p>
                    <p>経験豊富なマンション管理士の目で公平公正にチェック。</p>
                </div>
                <div class="flex gap-14 mt-9 max-md:flex-col-reverse max-md:gap-4 max-md:mt-4">
                    <div class="flex-1 text-[#4E4168] leading-[1.6] font-semibold text-[clamp(12px,2vw,20px)] max-md:leading-[1.3]">
                        <p class="mb-9 max-md:mb-2">マンション管理士は、豊富な経験と専門知識を活かし、工事の発注から見積もりの確認、工事の品質管理まで一貫してサポート。</p>
                        <p class="mb-9 max-md:mb-2">工事の過程で発生する可能性のある不正やトラブルを未然に防ぎ、公平公正な立場からアドバイスを行うため、透明性を確保し、住民の皆さんの大切な資産を守ります。</p>
                    </div>
                    <div class="flex-1"><img class="block w-full" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/illustration-7.png" alt=""></div>
                </div>
            </div>
            <div class="mb-[75px] max-md:mb-[40px]">
                <div class="max-w-[700px] mx-auto bg-[#70AF52] rounded-[22px] text-[#fff] text-center font-bold text-[clamp(16px,2vw,28px)] mb-[40px] max-md:mb-[15px]">
                    <p>マンション管理士導入のメリット その2</p>
                </div>
                <div class="components-heading text-[clamp(15px,2vw,30px)]">
                    <p>小さな困りごとから、将来不安に備える計画まで、</p>
                    <p>必要なだけ柔軟に。</p>
                </div>
                <div class="flex gap-14 mt-9 max-md:flex-col-reverse max-md:gap-4 max-md:mt-4">
                    <div class="flex-1 text-[#4E4168] leading-[1.6] font-semibold text-[clamp(12px,2vw,20px)] max-md:leading-[1.3]">
                        <p class="mb-9 max-md:mb-2">将来不安に備えるための長期修繕計画・管理規約・診断結果のチェックや改定などもOK。担い手不足で困っているマンション組合理事たちの頼れる味方です。</p>
                        <p>マンション管理士個人との契約のため、必要最低限の費用でそれぞれのニーズにピッタリなサービスを提供可能です（有料オプションあり）。</p>
                    </div>
                    <div class="flex-1"><img class="block w-full" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/illustration-8.png" alt=""></div>
                </div>
            </div>
            <div class="mb-[75px] max-md:mb-[40px]">
                <div class="max-w-[700px] mx-auto bg-[#70AF52] rounded-[22px] text-[#fff] text-center font-bold text-[clamp(16px,2vw,28px)] mb-[40px] max-md:mb-[15px]">
                    <p>マンション管理士導入のメリット その3</p>
                </div>
                <div class="components-heading text-[clamp(15px,2vw,30px)]">
                    <p>マンション住人と組合、</p>
                    <p>あるいは、マンション管理会社との架け橋に。</p>
                </div>
                <div class="flex gap-14 mt-9 max-md:flex-col-reverse max-md:gap-4 max-md:mt-4">
                    <div class="flex-1 text-[#4E4168] leading-[1.6] font-semibold text-[clamp(12px,2vw,20px)] max-md:leading-[1.3]">
                        <p class="mb-9 max-md:mb-2">マンション管理会社とご契約済みのマンション組合にも最適です。</p>
                        <p class="mb-9 max-md:mb-2">より身近な存在として、幅広い管理業務をサポートいたします。</p>
                        <p>また、マンション管理士とのコミュニケーションツールとして、組合のLINE公式アカウントをご利用できます。住民サービスの向上に貢献します。</p>
                    </div>
                    <div class="flex-1"><img class="block w-full" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/illustration-9.png" alt=""></div>
                </div>
            </div>
        </section>
        <section class="relative bg-[#384D6D] triangle-1 triangle-2">
            <div class="py-[20px]">
                <h3 class="components-heading text-white text-[clamp(14px,2.5vw,32px)]">レクシードのマンション管理サポートでは<br>経験豊富なマンション管理士がサポート対応します！</h3>
            </div>
        </section>
        <section class="bg-[#E3F2F9] pt-[92px] max-md:pt-[30px]">
            <div>
                <h3 class="components-heading text-[clamp(16px,2vw,24px)] mb-[30px]">マンション管理士になるには、国家試験のマンション管理士試験に合格し、登録することが必要</h3>
            </div>
            <div class="mb-20 max-md:mb-10">
                <div class="bg-[#FFF] rounded-[12px] flex px-12 pt-7 shadow-[4px_4px_4px_0px_rgba(0,0,0,0.25)] max-md:px-4 max-md:pt-4">
                    <div class="text-[clamp(10px,2vw,18px)] text-[#2A4061] leading-8 flex-[2_1_70%] max-md:leading-3 max-md:mr-2 font-bold max-md:pb-2">
                        <p class="components-heading text-left text-[clamp(20px,2vw,30px)] mb-4 max-md:mb-2 max-md:pb-2">マンション管理士とは</p>
                        <p class="mb-8 max-md:mb-1">マンンション管理の専門知識を持って共同住宅の施設管理、予算策定と管理、住民対応、法令遵守、緊急対応、業者調整などの仕事を担当します。</p>
                        <p class="mb-8 max-md:mb-1">これらの活動を通じて、共同住宅の運営を円滑にし、住民の生活をサポートします。</p>
                        <p class="mb-8 max-md:mb-1">マンション管理士になるには、国家試験のマンション管理士試験に合格し、登録することが必要となります。</p>
                    </div>
                    <div class="flex-[1_1_30%]"><img class="max-md:h-[80%] w-full object-cover" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/illustration-10.png" alt=""></div>
                </div>
            </div>
            <div class="mb-16 max-md:mb-6">
                <div class="w-[360px] mx-auto bg-[#FF0] rounded-[22px] text-[#4E4168] text-center font-bold text-[clamp(16px,2vw,28px)] mb-[40px] max-md:mb-[15px] max-md:w-[250px]">
                    <p>たとえば</p>
                </div>
                <div class="components-heading text-[clamp(22px,2.5vw,36px)] mb-10 max-md:mb-4">
                    <p>経験豊富なマンション管理士が</p>
                    <p>大規模修繕工事を対応すると</p>
                </div>
                <div>
                    <img src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/illustration-11.png" alt="">
                </div>
            </div>
            <div class="flex max-md:flex-col">
                <div class="flex-[1_1_40%] text-[#2A4061] text-[clamp(12px,2vw,22px)] leading-8 max-md:leading-3 font-bold pt-5">
                    <p class="mb-8 max-md:mb-3">信頼できるマンション管理士が豊富な知識と経験で工事内容・見積の提案をうけることによって、市場原理を活用した低コスト化。</p>
                    <p class="mb-8 max-md:mb-3">ご要望に応じた工事を実現でもともと計画されていた設計予算よりも低い価格で見積もりを実現します。</p>
                </div>
                <div class="flex-[2_1_60%]">
                    <img class="max-md:w-[80%] mx-auto" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/illustration-12.png" alt="">
                </div>
            </div>
        </section>
        <section class="relative bg-[#70AF52] triangle-1 triangle-3">
            <div class="py-[20px]">
                <h3 class="components-heading text-white text-[clamp(14px,2.5vw,30px)]">レクシードのマンション管理サポートでは<br>私たち、マンション管理士がサポート</h3>
            </div>
        </section>
        <section class="relative pb-[200px] max-md:pb-[200px]">
            <div id="section-back-image-2" class="absolute bottom-0 h-[480px] max-md:h-[175px] w-full -z-10 2xl:h-[800px]"></div>
            <div class="text-center components-heading text-[clamp(12px,2.5vw,30px)] pt-[82px] pb-[80px] max-lg:pt-[5%] max-lg:pb-[4%]">
                <h3>マンション管理士依頼の流れ <br class="md:hidden">マンション管理士は専門紹介会社より紹介</h3>
            </div>
            <div class="flex gap-7 text-[#2A4061] font-bold max-lg:flex-col">
                <div class="relative flex-1 border-4 border-[#2A4061] bg-[#E6F2F8] rounded-[20px] p-4 pt-8 max-md:p-2 max-md:pt-4">
                    <div class="max-lg:max-w-[550px] max-lg:mx-auto">
                        <p class="text-[20px] pb-[30px] text-center max-md:pb-0 whitespace-nowrap max-md:text-[16px] max-lg:pb-[20px]">マンション管理士の手配を依頼</p>
                        <img class="p-4 max-md:px-10 max-lg:px-12" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/logo.png" alt="">
                        <img class="absolute right-[-47px] top-[20%] z-10 max-lg:hidden" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/flow-1.png" alt="">
                        <img class="absolute right-[50%] left-[50%] -translate-x-1/2 -translate-y-1/2 bottom-[-71px] z-10 lg:hidden" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/flow-1-sp.png" alt="">
                    </div>
                </div>
                <div class="relative flex-1 border-4 border-[#2A4061] bg-[#E6F2F8] rounded-[20px] p-4 pt-8">
                    <div class="max-lg:max-w-[550px] max-lg:mx-auto">
                        <div class="w-[90%] mx-auto max-md:w-full">
                            <p class="text-[20px] text-right max-lg:text-center whitespace-nowrap max-md:text-[16px]">マンション管理士を組合に紹介</p>
                            <p class="text-[clamp(13px,1.5vw,16px)] text-right max-lg:text-center"><a class="underline link-icon" href="https://www.ring-solutions.com/" target="_blank">Ring-ndx 株式会社</a></p>
                        </div>
                        <div><img class="py-3 mx-auto max-lg:px-[10%]" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/logo-2.png" alt=""></div>
                        <div class="flex lg:px-[10%] items-center max-lg:justify-center">
                            <div class="max-md:pl-6">
                                <p class="text-[clamp(10px,1.2vw,12px)]">クレームという言葉をマンションからなくしたい</p>
                                <p class="text-[clamp(12px,1.2vw,14px)]">代表取締役 蔭山 貴弘</p>
                            </div>
                            <img src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/profile.png" alt="">
                        </div>
                        <img class="absolute right-[-47px] top-[20%] z-10 max-lg:hidden" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/flow-2.png" alt="">
                        <img class="absolute right-[50%] left-[50%] -translate-x-1/2 -translate-y-1/2 bottom-[-71px] z-10 lg:hidden" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/flow-2-sp.png" alt="">
                    </div>
                </div>
                <div class="flex-1 border-4 border-[#2A4061] bg-[#E6F2F8] rounded-[20px] p-4 pt-8 max-md:px-7">
                    <div class="max-lg:max-w-[550px] max-lg:mx-auto">
                        <p class="text-[20px] pb-[30px] text-center max-md:pb-[15px] whitespace-nowrap max-md:text-[16px]">マンション管理士の決定</p>
                        <div class="flex items-center justify-center">
                            <p class="text-[clamp(12px,1.2vw,14px)] max-md:flex-2">国家資格所有のマンション管理士が組合運営をサポート!!</p>
                            <img src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/illustration-13.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="bg-[#70AF52] h-[28px] max-md:h-[14px]"></div>
        <section class="bg-[rgba(140,198,63,0.17)]">
            <div class="components-heading text-[clamp(12px,2.5vw,32px)] py-[6%] max-md:px-[3%]">
                <h3>
                    <p>安心のマンション管理業務を提供</p>
                    <p>難しい資金計画作成・会計をマンション管理のプロに相談可能</p>
                </h3>
            </div>
            <div class="flex justify-center pb-[70px] max-md:pb-[30px]"><img class="max-md:w-[80%]" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/logo.png" alt=""></div>
            <div class="mx-auto pb-[40px] max-md:pb-[20px]">
                <p class="text-[#4E4168] font-bold text-[clamp(12px,2vw,23px)]">マンション管理の不明なことがあればマンション管理サポート顧問プランでお気軽にマンション管理に関するご質問にお応えします。また理事会・総会の運営などマンションの管理トータルに依頼することもできます。</p>
            </div>
            <div class="flex gap-[50px] mb-[86px] max-lg:flex-col max-lg:gap-[20px] max-lg:mb-[43px]">
                <div class="flex-1 bg-[#fff] shadow-[0_4px_4px_rgba(0,0,0,0.25)] text-center font-bold rounded-xl max-lg:pb-20 lg:p-4">
                    <div class="pt-[40px] pb-[20px] max-lg:pt-[20px] max-lg:pb-[10px]">
                        <p class="text-gray-600 text-[clamp(18px,2vw,28px)]">マンション管理士サポート</p>
                        <p class="text-slate-700 text-[clamp(30px,2vw,40px)] text-shadow">あんしん相談プラン</p>
                    </div>
                    <div class="max-w-[440px] mx-auto bg-amber-300 rounded-[22px] text-[#FFF] text-center text-shadow font-bold text-[clamp(16px,2vw,28px)] mb-[20px] max-md:mb-[10px] max-md:w-[70%]">
                        <p>月4万円から</p>
                    </div>
                    <div class="text-slate-700 font-bold max-md:pb-[25px] text-[clamp(18px,2vw,24px)]">
                        <div class="plan"><img src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/check-icon.png" class="mr-1" alt="">
                            <p>組合LINE公式アカウント</p>
                        </div>
                        <div class="plan"><img src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/check-icon.png" class="mr-1" alt="">
                            <p>客観的な助言&middot;相談</p>
                        </div>
                        <div class="plan"><img src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/check-icon.png" class="mr-1" alt="">
                            <p>見積チェック</p>
                        </div>
                        <div class="plan"><img src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/check-icon.png" class="mr-1" alt="">
                            <p>診断書チェック</p>
                        </div>
                        <div class="plan"><img src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/check-icon.png" class="mr-1" alt="">
                            <p>規約チェック</p>
                        </div>
                    </div>
                </div>
                <div class="flex-1 bg-[#fff] shadow-[0_4px_4px_rgba(0,0,0,0.25)] text-center font-bold rounded-xl p-4">
                    <div class="pt-[40px] pb-[20px] max-md:pt-[20px] max-md:pb-[10px]">
                        <p class="text-gray-600 text-[clamp(18px,2vw,28px)]">マンション管理士サポート</p>
                        <p class="text-slate-700 text-[clamp(30px,2vw,40px)] text-shadow">組合おまかせプラン</p>
                    </div>
                    <div class="max-w-[420px] mx-auto bg-amber-300 rounded-[22px] text-[#FFF] text-center text-shadow font-bold text-[clamp(16px,2vw,28px)] mb-[20px] max-md:mb-[10px] max-md:w-[70%]">
                        <p>月8万円から</p>
                    </div>
                    <div class="text-slate-700 font-bold pb-[50px] max-md:pb-[25px] text-[clamp(18px,2vw,24px)]">
                        <div class="plan"><img src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/check-icon.png" class="mr-1" alt="">
                            <p>組合LINE公式アカウント</p>
                        </div>
                        <div class="plan"><img src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/check-icon.png" class="mr-1" alt="">
                            <p>客観的な助言&middot;相談</p>
                        </div>
                        <div class="plan"><img src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/check-icon.png" class="mr-1" alt="">
                            <p>見積チェック</p>
                        </div>
                        <div class="plan"><img src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/check-icon.png" class="mr-1" alt="">
                            <p>診断書チェック</p>
                        </div>
                        <div class="plan"><img src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/check-icon.png" class="mr-1" alt="">
                            <p>規約チェック</p>
                        </div>
                        <div class="plan"><img src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/check-icon.png" class="mr-1" alt="">
                            <p>組合理事業務&middot;運営</p>
                        </div>
                        <div class="plan"><img src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/check-icon.png" class="mr-1" alt="">
                            <p>専門業者との交渉</p>
                        </div>
                        <div class="plan"><img src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/check-icon.png" class="mr-1" alt="">
                            <p>長期修繕計画見直し</p>
                        </div>
                        <div class="plan"><img src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/check-icon.png" class="mr-1" alt="">
                            <p>管理規約見直し</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative mb-[63px]">
                <div class="text-slate-700 text-[clamp(16px,2vw,32px)] font-black pb-6 text-shadow">マンション管理サポートサービス利用の流れ</div>
                <div class="grid gap-4">
                    <div class="flex bg-[#FFF] rounded-[36px] p-6 max-md:p-3">
                        <div class="inline-block px-[5%] text-[#70AF52] text-[clamp(14px,2vw,26px)] font-black">STEP1</div>
                        <div class="w-full text-[#303F6A] text-[clamp(14px,2vw,26px)] font-black">お問合せ(窓口はLINE可)</div>
                    </div>
                    <div class="flex bg-[#FFF] rounded-[36px] p-6 max-md:p-3">
                        <div class="inline-block px-[5%] text-[#70AF52] text-[clamp(14px,2vw,26px)] font-black">STEP2</div>
                        <div class="w-full text-[#303F6A] text-[clamp(14px,2vw,26px)] font-black">ご返答&middot;個別のご相談</div>
                    </div>
                    <div class="flex bg-[#FFF] rounded-[36px] p-6 max-md:p-3">
                        <div class="inline-block px-[5%] text-[#70AF52] text-[clamp(14px,2vw,26px)] font-black">STEP3</div>
                        <div class="w-full text-[#303F6A] text-[clamp(14px,2vw,26px)] font-black">ご契約（組合とレクシードが契約）</div>
                    </div>
                    <div class="flex bg-[#FFF] rounded-[36px] p-6 max-md:p-3">
                        <div class="inline-block px-[5%] text-[#70AF52] text-[clamp(14px,2vw,26px)] font-black">STEP4</div>
                        <div class="w-full text-[#303F6A] text-[clamp(14px,2vw,26px)] font-black">マンション管理士による導入</div>
                    </div>
                    <div class="flex bg-[#FFF] rounded-[36px] p-6 max-md:p-3">
                        <div class="inline-block px-[5%] text-[#70AF52] text-[clamp(14px,2vw,26px)] font-black">STEP5</div>
                        <div class="w-full text-[#303F6A] text-[clamp(14px,2vw,26px)] font-black">ご返答・個別のご相談</div>
                    </div>
                </div>
                <img class="absolute right-0 bottom-[-15px] max-md:w-[30vw] max-md:bottom-[-50px]" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/illustration-14.png" alt="">
            </div>
            <div id="enquiry">
                <div class="components-heading text-[clamp(18px,2vw,32px)] pb-8 max-xl:pb-4">
                    <p>レクシードマンション管理サポートを検討しませんか</p>
                    <p>まずはお問い合わせください</p>
                </div>
                <div class="bg-gradient-to-b from-lime-500 to-lime-600 rounded-[20px] shadow-inner py-[26px] px-[46px] mb-[55px] max-xl:py-[10px] max-xl:px-[20px] max-xl:mb-[20px]">
                    <p class="text-center text-white text-[clamp(18px,2vw,26px)] font-bold">お気軽にご連絡ください</p>
                    <p class="text-center text-[#FFFF00] text-[clamp(20px,2.5vw,49px)] font-black pb-[20px] max-xl:pb-[10px]">お問合わせ・ご相談・お申込み</p>
                    <div class="flex justify-between items-center bg-white rounded-xl py-[27px] px-[50px] max-xl:py-[8px]  max-xl:px-[10px]">
                        <div class="flex items-center gap-8 max-xl:gap-2 max-xl:w-full"><img class="max-xl:w-[15%]" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/line-icon.png" alt=""><img class="max-xl:w-[80%]" class="h-full" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/line-text.png" alt=""></div>
                        <div class="w-[200px] h-[200px] bg-[#D9D9D9] max-xl:hidden"><img class="max-xl:w-[15%]" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/532patvm.png" alt=""></div>
                    </div>
                    <div class="mx-auto w-[200px] h-[200px] bg-[#D9D9D9] my-5 rounded-xl overflow-hidden max-md:hidden block xl:hidden"><img class="w-full" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/532patvm.png" alt=""></div>
                    <div class="mx-auto w-[200px] bg-[#D9D9D9] my-5 rounded-xl overflow-hidden block md:hidden">
                        <a href="https://lin.ee/f9zYZxb"><img class="border-2 border-white rounded-xl" src="{{ asset('img/ja.png') }}" alt="友だち追加" height="36" border="0"></a>
                    </div>
                    <div class="flex items-center justify-around">
                        <p class="text-white text-[clamp(18px,2vw,47px)] font-black">電話番号</p>
                        <a class="block text-white text-[clamp(30px,5vw,94px)] font-black" href="tel:042-980-5080">042-980-5080</a>
                    </div>
                </div>
                <div><img class="mx-auto" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/illustration-15.png" alt=""></div>
            </div>
        </section>
        <section class="relative bg-[#ECCA44] triangle-1 triangle-4">
            <div class="py-[20px]">
                <h3 class="components-heading text-white text-[clamp(14px,2.5vw,30px)]">単発の突然の困りごと&middot;工事見積もり&middot;工事依頼などの<br>ご相談もお気軽にお問い合わせください。</h3>
            </div>
        </section>
        <section class="pt-[50px] pb-[34px] max-md:pt-[20px] max-md:pb-[15px]">
            <div class="components-heading text-[#1B1464] text-[clamp(20px,2.5vw,32px)] mb-[27px] max-md:mb-4">
                <h3>レクシードだからできるマンション管理サポート</h3>
                <a class="underline link-icon font-medium text-base" href="https://rexceed-kt.co.jp" target="_blank">株式会社レクシード公式サイト</a>
            </div>
            <div class="flex gap-[24px] mb-[40px] max-md:flex-col max-md:mb-[20px]">
                <div class="flex-1">
                    <div class="mb-[24px] max-md:mb-[10px]"><img class="w-full" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/photograph-1.png" alt=""></div>
                    <div class="text-[#2A4061] text-[clamp(12px,2vw,22px)] font-medium">
                        <p>防水対策・雨漏りに強い（マンションに限らず、難易度の高いリゾート施設などさまざまな商業施設の防水に対応）</p>
                    </div>
                </div>
                <div class="flex-1">
                    <div class="mb-[24px] max-md:mb-[10px]"><img class="w-full" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/photograph-2.png" alt=""></div>
                    <div class="text-[#2A4061] text-[clamp(12px,2vw,22px)] font-medium">
                        <p>右肩上がりで成長を続けている。地元を中心に修繕工事を的確に受注し、首都圏を中心に安定的な受注を広げています</p>
                    </div>
                </div>
                <div class="flex-1">
                    <div class="mb-[24px] max-md:mb-[10px]"><img class="w-full" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/photograph-3.png" alt=""></div>
                    <div class="text-[#2A4061] text-[clamp(12px,2vw,22px)] font-medium">
                        <p>BR 工法という特殊な工法の特許技術を共有化。技術力でお客様に貢献します。</p>
                    </div>
                </div>
            </div>
            <div><img class="w-[37%] max-md:w-full max-md:py-2 max-md:px-8" src="https://recxeed-storage.s3.ap-northeast-1.amazonaws.com/assets/images/logo.png" alt=""></div>
        </section>
    </main>
    <footer class="bg-[#002C80] text-white max-md:h-auto pb-16">
        <div class="max-w-[1300px] mx-auto px-[4%] text-[clamp(12px,2vw,18px)] pt-7">
            <div class="py-4">
                <h1 class="underline mb-1">お知らせ</h1>
                <div class="flex max-md:flex-col pb-2 max-md:pb-3">
                    <p class="flex-[1_1_15%] max-md:font-bold">2024年6月1日</p>
                    <p class="flex-[2_1_85%]">マンション総合EXPOに出展いたしました。</p>
                </div>
                <div class="flex max-md:flex-col pb-2 max-md:pb-3">
                    <p class="flex-[1_1_15%] max-md:font-bold">2024年7月1日</p>
                    <p class="flex-[2_1_85%]">オンラインセミナー（2024年8月2日）を開催いたします。</p>
                </div>
                <div class="flex max-md:flex-col pb-2 max-md:pb-3">
                    <p class="flex-[1_1_15%] max-md:font-bold">2024年7月20日</p>
                    <p class="flex-[2_1_85%]">「マンション管理サポート」オープンいたしました。</p>
                </div>
            </div>
            <h1 class="underline mb-1">会社ご案内</h1>
            <div class="flex max-md:flex-col pb-2 max-md:pb-3">
                <p class="flex-[1_1_15%] max-md:font-bold">本社</p>
                <p class="flex-[2_1_85%]">〒186-0003東京都国立市富士見台4-11-32 <br class="md:hidden">TEL : 042-505-9522 / FAX : 042-505-9528</p>
            </div>
            <div class="flex max-md:flex-col pb-2 max-md:pb-3">
                <p class="flex-[1_1_15%] max-md:font-bold">渋谷支店</p>
                <p class="flex-[2_1_85%]">〒151-0051 東京都渋谷区千駄ヶ谷3-7-2 <br class="md:hidden">TEL : 03-6432-9520</p>
            </div>
            <div class="flex max-md:flex-col pb-2 max-md:pb-3">
                <p class="flex-[1_1_15%] max-md:font-bold">町田支店</p>
                <p class="flex-[2_1_85%]">〒194-0021 東京都町田市中町1-30-2 <br class="md:hidden">TEL : 042-732-3775</p>
            </div>
            <div class="flex max-md:flex-col">
                <p class="flex-[1_1_15%] max-md:font-bold">飯能営業所</p>
                <p class="flex-[2_1_85%]">〒357-0024 埼玉県飯能市緑町1-9 <br class="md:hidden">TEL : 042-980-5080 / FAX : 042-980-5081</p>
            </div>
        </div>
    </footer>
</body>

</html>
