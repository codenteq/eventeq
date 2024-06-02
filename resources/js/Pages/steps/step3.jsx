import {Button, Input, Label} from "@codenteq/interfeys";
import React, {useState} from "react";

export default function Step3({ onNext, onPrev }) {
    const [dontCampingEquipment, setDontCampingEquipment] = useState(false);

    const handleDontCampingEquipmentChange = (event) => {
        setDontCampingEquipment(event.target.checked);
    };

    const handlePrevClick = () => {
        console.log('Önceki butona tıklandı!');
        onPrev();
    };

    const handleNextClick = () => {
        console.log('Sonraki butona tıklandı!');
        onNext();
    };
    return (
        <>
            <div>
                <div className="flex items-center gap-3 mb-6">
                    <Input
                        name="dont_camping_equipment"
                        id="dont_camping_equipment"
                        type="checkbox"
                        checked={dontCampingEquipment}
                        onChange={handleDontCampingEquipmentChange}
                    />
                    <Label htmlFor="dont_camping_equipment">
                        Kamp malzemelerini (Çadır, sandalye, tulum vb.),
                        uygun bir fiyata kamp alanından temin etmek ister misiniz?
                    </Label>
                </div>

                {dontCampingEquipment && (
                    <div className="grid gap-5 mb-6 lg:grid-cols-2">
                        <Input
                            name="tent"
                            type="number"
                            label="Çadır"
                            helpText="Kaç adet çadır getirebilirsiniz?"
                            className="block w-full"
                        />
                        <Input
                            name="sleeping_bag"
                            type="number"
                            label="Uyku tulumu"
                            helpText="Kaç adet uyku tulumu getirebilirsiniz?"
                            className="block w-full"
                        />
                        <Input
                            name="Mat"
                            type="number"
                            label="Mat"
                            helpText="Kaç adet mat getirebilirsiniz?"
                            className="block w-full"
                        />
                        <Input
                            name="chair"
                            type="number"
                            label="Sandalye"
                            helpText="Kaç adet sandalye getirebilirsiniz?"
                            className="block w-full"
                        />
                    </div>
                )}
            </div>
            <div className="flex items-center justify-between">
                <button type="button" onClick={handlePrevClick} className="mr-2">
                    Önceki
                </button>
                <Button type="submit" label="Sonraki" onClick={handleNextClick}/>
            </div>
        </>
    )
}
