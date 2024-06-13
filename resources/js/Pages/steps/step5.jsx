import {Accordion, AccordionBody, AccordionHeader, AccordionList, Input, Label, Modal} from "@codenteq/interfeys";
import React, {useState} from "react";

export default function Step5({data, setData, event}) {
    const [isOpen, setIsOpen] = useState(false);

    return (
        <>
            <div className="my-5">
                <h3>Adım 5: Seyahat Bilgileri</h3>
            </div>
            <div className="grid gap-5 mb-6 lg:grid-cols-2">
                <Input
                    name="arrival_date"
                    value={data.arrival_date}
                    onChange={(e) => setData('arrival_date', e.target.value)}
                    type="date"
                    label="Varış tarihi"
                    className="block w-full"
                    required
                />
                <Input
                    name="departure_date"
                    value={data.departure_date}
                    onChange={(e) => setData('departure_date', e.target.value)}
                    type="date"
                    required
                    label="Ayrılış tarihi"
                    className="block w-full"
                />
            </div>
            <div className="grid-cols-none w-full flex items-center gap-3 mb-6">
                <Input
                    name="privacy"
                    id="privacy"
                    type="checkbox"
                    required={true}
                />
                <Label htmlFor="privacy">
                    <button title="Okumak için tılayın." onClick={() => setIsOpen(true)} type={'button'}
                            className="underline">Aydınlatma Metnini
                    </button>
                    <AccordionList>
                        <Accordion>
                            <AccordionHeader>
                                {' '}okudum, kişisel verilerimin işlenmesini onaylıyorum.
                            </AccordionHeader>
                            <AccordionBody>
                                Kalebey Yerel Eylem Grubu Derneği tarafından düzenlenecek “Sandras Gökyüzü Gözlem
                                Şenliğine” katılım için, 6698 Sayılı Kişisel Verilerin Korunması Kanunu’nun (“KVKK”)
                                ilgili hükümlerine uygun olarak bilgime sunulan Aydınlatma Metninde yer alan
                                açıklamaları, okudum, anladım, bilgilendirildim. Sandras Gökyüzü Gözlem Şenliği
                                katılımcılarına ait verilerin, “KVKK Aydınlatma Metni”nde yer alan bilgiler ışığında,
                                ilgili süreç kapsamında işlenme amacı ile sınırlı olmak üzere kullanılmasını, gereken
                                süre zarfında saklanmasını ve bu hususta tarafıma gerekli aydınlatmanın yapıldığını ve
                                Kalebey Yerel Eylem Grubu Derneği tarafından işlenmesine, muhafaza edilmesine ve
                                aktarılmasına rıza gösterdiğimi beyan ediyorum. İşbu açık rıza metnini okudum ve
                                anladım. Yukarıda yer alan hususlara bilerek ve isteyerek rıza gösterdiğimi beyan
                                ederim. Kişisel verilerimin metinde belirtilen şekillerde işlenmesini ve aktarılmasını
                                onaylıyorum ve izin veriyorum.
                            </AccordionBody>
                        </Accordion>
                    </AccordionList>
                </Label>
            </div>

            {isOpen && (
                <Modal title="AYDINLATMA METNİ" isOpen={isOpen} setIsOpen={setIsOpen}>
                    <div style={{maxHeight: '80vh', overflowY: 'auto'}}>
                        <p>Kalebey Yerel Eylem Grubu Derneği olarak kişisel verilerinizin güvenliği hususuna azami
                            hassasiyet göstermekteyiz. Bu bilinçle, başta özel hayatın gizliliği olmak üzere
                            kişilerin temel hak ve özgürlüklerini korumak ve kişisel verilerin 6698 sayılı Kişisel
                            Verilerin Korunması Kanunu (“KVK Kanunu”)’na uygun olarak işlenerek, muhafaza edilmesine
                            büyük önem atfetmekteyiz. Bu sorumluluğumuzun tam idraki ile Veri Sorumlusu sıfatıyla,
                            kişisel verilerinizi aşağıda izah edildiği surette ve mevzuat tarafından emredilen
                            sınırlar çerçevesinde işlemekteyiz.</p>

                        <h2>1. Kişisel Verilerin Toplanması, İşlenmesi ve İşleme Amaçları</h2>
                        <p>İşbu Aydınlatma Metni kapsamında işlenen kişisel verileriniz; dernek nezdinde yapılacak
                            duyuru görsellerinin hazırlanması ve duyurulması faaliyeti kapsamında organizasyon ve
                            etkinlik yönetimi amacıyla KVK Kanunu’nun 5. ve 6. maddelerinde belirtilen kişisel veri
                            işleme şartları ve amaçları dahilinde işlenecektir.</p>

                        <h2>2. İşlenen Kişisel Verilerin Kimlere ve Hangi Amaçla Aktarılabileceği</h2>
                        <p>Toplanan kişisel verileriniz; gözlem şenliği ile ilgili hizmetlerin sürdürülmesi için
                            kullanmak amacıyla amacıyla, kanunen yetkili kamu kurumları ve özel kişilere, KVK
                            Kanunu’nun 8. ve 9. maddelerinde belirtilen kişisel veri işleme şartları ve amaçları
                            çerçevesinde aktarılabilecektir.</p>

                        <h2>3. Kişisel Veri Toplamanın Yöntemi ve Hukuki Sebebi</h2>
                        <p>Kişisel verileriniz, her türlü sözlü, yazılı ortamda, yukarıda yer verilen amaçlar
                            doğrultusunda Kalebey Yerel Eylem Grubu Derneği olarak sunduğumuz ürün ve hizmetlerin
                            belirlenen yasal çerçevede sunulabilmesi ve bu kapsamda Organizasyonumuzun sözleşme ve
                            yasadan doğan mesuliyetlerini eksiksiz ve doğru bir şekilde yerine getirebilmesi gayesi
                            ile edinilir. Bu hukuki sebeple toplanan kişisel verileriniz KVK Kanunu’nun 5. ve 6.
                            maddelerinde belirtilen kişisel veri işleme şartları ve amaçları kapsamında bu metnin
                            (1) ve (2) numaralı maddelerinde belirtilen amaçlarla da işlenebilmekte ve
                            aktarılabilmektedir.</p>

                        <h2>4. Kişisel Veri Sahibinin KVK Kanunu’nun 11. maddesinde Sayılan Hakları</h2>
                        <p>Kişisel veri sahipleri olarak, haklarınıza ilişkin taleplerinizi, işbu Aydınlatma
                            Metni’nde aşağıda düzenlenen yöntemlerle Organizasyonumuza iletmeniz durumunda
                            Organizasyonumuz talebin niteliğine göre talebi en geç otuz gün içinde ücretsiz olarak
                            sonuçlandıracaktır. Ancak, Kişisel Verileri Koruma Kurulunca bir ücret öngörülmesi
                            halinde, Organizasyonumuz tarafından belirlenen tarifedeki ücret alınacaktır. Bu
                            kapsamda kişisel veri sahipleri;</p>
                        <ul>
                            <li>Kişisel veri işlenip işlenmediğini öğrenme,</li>
                            <li>Kişisel verileri işlenmişse buna ilişkin bilgi talep etme,</li>
                            <li>Kişisel verilerin işlenme amacını ve bunların amacına uygun kullanılıp
                                kullanılmadığını öğrenme,
                            </li>
                            <li>Yurt içinde veya yurt dışında kişisel verilerin aktarıldığı üçüncü kişileri bilme,
                            </li>
                            <li>Kişisel verilerin eksik veya yanlış işlenmiş olması hâlinde bunların düzeltilmesini
                                isteme ve bu kapsamda yapılan işlemin kişisel verilerin aktarıldığı üçüncü kişilere
                                bildirilmesini isteme,
                            </li>
                            <li>KVK Kanunu’nun ve ilgili diğer kanun hükümlerine uygun olarak işlenmiş olmasına
                                rağmen, işlenmesini gerektiren sebeplerin ortadan kalkması hâlinde kişisel verilerin
                                silinmesini veya yok edilmesini isteme ve bu kapsamda yapılan işlemin kişisel
                                verilerin aktarıldığı üçüncü kişilere bildirilmesini isteme,
                            </li>
                            <li>İşlenen verilerin münhasıran otomatik sistemler vasıtasıyla analiz edilmesi
                                suretiyle kişinin kendisi aleyhine bir sonucun ortaya çıkmasına itiraz etme,
                            </li>
                            <li>Kişisel verilerin kanuna aykırı olarak işlenmesi sebebiyle zarara uğraması hâlinde
                                zararın giderilmesini talep etme haklarına sahiptir.
                            </li>
                        </ul>

                        <p>KVK Kanunu’nun 13. maddesinin 1. fıkrası gereğince, yukarıda belirtilen haklarınızı
                            kullanmak ile ilgili talebinizi, yazılı veya Kişisel Verileri Koruma Kurulu’nun
                            belirlediği diğer yöntemlerle Organizasyonumuza iletebilirsiniz. Kişisel Verileri Koruma
                            Kurulu, şu aşamada herhangi bir yöntem belirlemediği için, başvurunuzu, KVK Kanunu
                            gereğince, yazılı olarak Kalebey Yerel Eylem Grubu Derneğine iletmeniz gerekmektedir. Bu
                            çerçevede derneğimiz KVK Kanunu’nun 11. maddesi kapsamında yapacağınız başvurularda
                            yazılı olarak başvurunuzu ileteceğiniz kanallar ve usuller aşağıda açıklanmaktadır.</p>

                        <p>Yukarıda belirtilen haklarınızı kullanmak için kimliğinizi tespit edici gerekli bilgiler
                            ile KVK Kanunu’nun 11. maddesinde belirtilen haklardan kullanmayı talep ettiğiniz
                            hakkınıza yönelik açıklamalarınızı içeren talebinizi, <a
                                href="mailto:info@kalebeyyeg.com">info@kalebeyyeg.com</a> e-posta
                            adresine iletebilirsiniz. Talebinizin niteliğine göre en kısa sürede ve en geç otuz gün
                            içinde başvurularınız ücretsiz olarak sonuçlandırılacaktır; ancak işlemin ayrıca bir
                            maliyet gerektirmesi halinde Kişisel Verileri Koruma Kurulu tarafından belirlenecek
                            tarifeye göre tarafınızdan ücret talep edilebilecektir.</p>
                    </div>
                </Modal>
            )}
        </>
    )
}
