import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PlaygroundInfoComponent } from './playground-info.component';

describe('PlaygroundInfoComponent', () => {
  let component: PlaygroundInfoComponent;
  let fixture: ComponentFixture<PlaygroundInfoComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [PlaygroundInfoComponent]
    });
    fixture = TestBed.createComponent(PlaygroundInfoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
